<?php

namespace Pronamic\WordPress\Pay\Gateways\MollieIDeal;

use Pronamic\WordPress\Pay\Core\Util;
use Pronamic\WordPress\Pay\Core\XML\Security;
use SimpleXMLElement;
use stdClass;
use WP_Error;

/**
 * Title: Mollie
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Client {
	/**
	 * Mollie API endpoint URL
	 *
	 * @var string
	 */
	const API_URL = 'https://secure.mollie.nl/xml/ideal/';

	/**
	 * Mollie partner ID
	 *
	 * @var string
	 */
	private $partner_id;

	/**
	 * Mollie profile key
	 *
	 * @var string
	 */
	private $profile_key;

	/**
	 * Indicator to use test mode or not
	 *
	 * @var boolean
	 */
	private $test_mode;

	/**
	 * Error
	 *
	 * @var WP_Error
	 */
	private $error;

	/**
	 * Constructs and initializes an Mollie client object
	 *
	 * @param string $partner_id
	 */
	public function __construct( $partner_id ) {
		$this->partner_id = $partner_id;
	}

	/**
	 * Error
	 *
	 * @return WP_Error
	 */
	public function get_error() {
		return $this->error;
	}

	/**
	 * Set test mode
	 *
	 * @param boolean $test_mode
	 */
	public function set_test_mode( $test_mode ) {
		$this->test_mode = $test_mode;
	}

	/**
	 * Get the default parameters wich are required in every Mollie request
	 *
	 * @param string $action
	 * @param array $parameters
	 *
	 * @return array
	 */
	private function get_parameters( $action, array $parameters = array() ) {
		$parameters['a']         = $action;
		$parameters['partnerid'] = $this->partner_id;

		if ( $this->test_mode ) {
			$parameters['testmode'] = 'true';
		}

		if ( isset( $parameters['reporturl'] ) && defined( 'MOLLIE_IDEAL_REPORT_URL' ) ) {
			$parameters['reporturl'] = MOLLIE_IDEAL_REPORT_URL;
		}

		return $parameters;
	}

	/**
	 * Send request with the specified action and parameters
	 *
	 * @param string $action
	 * @param array $parameters
	 *
	 * @return bool|string|WP_Error
	 */
	private function send_request( $action, array $parameters = array() ) {
		$parameters = $this->get_parameters( $action, $parameters );

		/*
		 * WordPress functions use URL encoding.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/build_query
		 * @link http://codex.wordpress.org/Function_Reference/add_query_arg
		 */
		$url = Util::build_url( self::API_URL, $parameters );

		return Util::remote_get_body( $url, 200 );
	}

	/**
	 * Get banks
	 *
	 * @return bool|array
	 */
	public function get_banks() {
		$banks = false;

		$result = $this->send_request( Actions::BANK_LIST );

		if ( is_wp_error( $result ) ) {
			$this->error = $result;
		} else {
			$xml = Util::simplexml_load_string( $result );

			if ( is_wp_error( $xml ) ) {
				$this->error = $xml;
			} else {
				$banks = array();

				foreach ( $xml->bank as $bank ) {
					$id   = (string) $bank->bank_id;
					$name = (string) $bank->bank_name;

					$banks[ $id ] = $name;
				}
			}
		}

		return $banks;
	}

	/**
	 * Parse document
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return bool|stdClass
	 */
	private function parse_document( SimpleXMLElement $xml ) {
		$result = false;

		if ( isset( $xml->item ) ) {
			if ( 'error' === $xml->item['type'] ) {
				$error = new Error(
					(string) $xml->item->errorcode,
					(string) $xml->item->message
				);

				$this->error = new WP_Error( 'mollie_error', (string) $error, $error );
			}
		}

		if ( isset( $xml->order ) ) {
			$order = new stdClass();

			$order->transaction_id = (string) $xml->order->transaction_id;
			$order->amount         = (string) $xml->order->amount;
			$order->currency       = (string) $xml->order->currency;
			$order->url            = (string) $xml->order->URL;
			$order->message        = (string) $xml->order->message;

			$result = $order;
		}

		return $result;
	}

	/**
	 * Create payment with the specified details
	 *
	 * @param string $bank_id
	 * @param float $amount
	 * @param string $description
	 * @param string $return_url
	 * @param string $report_url
	 *
	 * @return bool|stdClass
	 */
	public function create_payment( $bank_id, $amount, $description, $return_url, $report_url ) {
		$parameters = array(
			'bank_id'     => $bank_id,
			'amount'      => $amount,
			'description' => $description,
			'reporturl'   => $report_url,
			'returnurl'   => $return_url,
		);

		if ( $this->profile_key ) {
			$parameters['profile_key'] = $this->profile_key;
		}

		$result = $this->send_request( Actions::FETCH, $parameters );

		if ( false !== $result && ! is_wp_error( $result ) ) {
			$xml = Util::simplexml_load_string( $result );

			if ( is_wp_error( $xml ) ) {
				$this->error = $xml;
			} else {
				$result = self::parse_document( $xml );
			}
		}

		return $result;
	}

	/**
	 * Check payment with the specified transaction ID
	 *
	 * @param string $transaction_id
	 *
	 * @return bool|stdClass
	 */
	public function check_payment( $transaction_id ) {
		$parameters = array(
			'transaction_id' => $transaction_id,
		);

		$result = $this->send_request( Actions::CHECK, $parameters );

		if ( false !== $result ) {
			$xml = Util::simplexml_load_string( $result );

			if ( is_wp_error( $xml ) ) {
				$this->error = $xml;
			} else {
				$order = new stdClass();

				$order->transaction_id = Security::filter( $xml->order->transaction_id );
				$order->amount         = Security::filter( $xml->order->amount );
				$order->currency       = Security::filter( $xml->order->currency );
				$order->payed          = Security::filter( $xml->order->payed, FILTER_VALIDATE_BOOLEAN );
				$order->status         = Security::filter( $xml->order->status );

				$order->consumer          = new stdClass();
				$order->consumer->name    = Security::filter( $xml->order->consumer->consumerName );
				$order->consumer->account = Security::filter( $xml->order->consumer->consumerAccount );
				$order->consumer->city    = Security::filter( $xml->order->consumer->consumerCity );

				$result = $order;
			}
		}

		return $result;
	}
}
