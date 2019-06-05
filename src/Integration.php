<?php

namespace Pronamic\WordPress\Pay\Gateways\MollieIDeal;

use Pronamic\WordPress\Pay\Gateways\Common\AbstractIntegration;

/**
 * Title: Mollie iDEAL integration
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   1.0.0
 */
class Integration extends AbstractIntegration {
	public function __construct() {
		$this->id            = 'mollie-ideal';
		$this->name          = 'Mollie - iDEAL';
		$this->dashboard_url = 'http://www.mollie.nl/beheer/';
		$this->provider      = 'mollie';
		$this->deprecated    = true;
	}

	public function get_settings_fields() {
		$fields = array();

		// Partner ID
		$fields[] = array(
			'section'     => 'general',
			'filter'      => FILTER_SANITIZE_STRING,
			'meta_key'    => '_pronamic_gateway_mollie_partner_id',
			'title'       => __( 'Partner ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
			'description' => __( 'Mollie.nl accountnummer. Op het gespecificeerde account wordt na succesvolle betaling tegoed bijgeschreven.', 'pronamic_ideal' ),
		);

		// Profile Key
		$fields[] = array(
			'section'     => 'general',
			'filter'      => FILTER_SANITIZE_STRING,
			'meta_key'    => '_pronamic_gateway_mollie_profile_key',
			'title'       => __( 'Profile Key', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'regular-text', 'code' ),
			'description' => sprintf(
				__( 'Hiermee kunt u een ander websiteprofielen selecteren om uw betaling aan te linken. Gebruik de waarde uit het veld Key uit het profiel overzicht. [<a href="%s" target="_blank">bekijk overzicht van uw profielen</a>].', 'pronamic_ideal' ),
				'https://www.mollie.nl/beheer/account/profielen/'
			),
		);

		return $fields;
	}

	public function get_config( $post_id ) {
		$config = new Config();

		$config->partner_id  = get_post_meta( $post_id, '_pronamic_gateway_mollie_partner_id', true );
		$config->profile_key = get_post_meta( $post_id, '_pronamic_gateway_mollie_profile_key', true );

		$config->mode = get_post_meta( $post_id, '_pronamic_gateway_mode', true );

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $post_id ) {
		return new Gateway( $this->get_config( $post_id ) );
	}
}
