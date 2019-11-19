<?php

namespace Pronamic\WordPress\Pay\Gateways\MollieIDeal;

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: Mollie gateway
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.1
 * @since   1.0.0
 */
class Gateway extends Core_Gateway {
	/**
	 * Client.
	 *
	 * @var Client
	 */
	public $client;

	/**
	 * Constructs and initializes an Mollie gateway
	 *
	 * @param Config $config Config.
	 */
	public function __construct( Config $config ) {
		parent::__construct( $config );

		$this->set_method( self::METHOD_HTTP_REDIRECT );

		$this->client = new Client( $config->partner_id );
		$this->client->set_test_mode( self::MODE_TEST === $config->mode );
	}

	/**
	 * Get issuers
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_issuers()
	 */
	public function get_issuers() {
		$groups = array();

		try {
			$result = $this->client->get_banks();

			$groups[] = array(
				'options' => $result,
			);
		} catch ( \Exception $e ) {
			$this->error = new \WP_Error( 'ideal_advanced_v3_error', $e->getMessage() );
		}

		return $groups;
	}

	/**
	 * Get supported payment methods
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_supported_payment_methods()
	 */
	public function get_supported_payment_methods() {
		return array(
			PaymentMethods::IDEAL,
		);
	}

	/**
	 * Start
	 *
	 * @see Core_Gateway::start()
	 *
	 * @param Payment $payment Payment.
	 */
	public function start( Payment $payment ) {
		$result = $this->client->create_payment(
			$payment->get_issuer(),
			$payment->get_total_amount()->get_cents(),
			$payment->get_description(),
			$payment->get_return_url(),
			$payment->get_return_url()
		);

		if ( false !== $result ) {
			$payment->set_transaction_id( $result->transaction_id );
			$payment->set_action_url( $result->url );
		}
	}

	/**
	 * Update status of the specified payment
	 *
	 * @param Payment $payment Payment.
	 */
	public function update_status( Payment $payment ) {
		try {
			$result = $this->client->check_payment( $payment->get_transaction_id() );
		} catch ( \Exception $e ) {
			return;
		}

		if ( false !== $result ) {
			$consumer = $result->consumer;

			switch ( $result->status ) {
				case Statuses::SUCCESS:
					$payment->set_consumer_name( $consumer->name );
					$payment->set_consumer_account_number( $consumer->account );
					$payment->set_consumer_city( $consumer->city );
					$payment->set_status( $result->status );

					break;
				case Statuses::CANCELLED:
				case Statuses::EXPIRED:
				case Statuses::FAILURE:
					$payment->set_status( $result->status );

					break;
				case Statuses::CHECKED_BEFORE:
					// Nothing to do here.
					break;
			}
		}
	}
}
