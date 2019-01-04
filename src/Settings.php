<?php

namespace Pronamic\WordPress\Pay\Gateways\MollieIDeal;

use Pronamic\WordPress\Pay\Core\GatewaySettings;

/**
 * Title: Mollie iDEAL gateway settings
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   1.1.0
 */
class Settings extends GatewaySettings {
	public function __construct() {
		add_filter( 'pronamic_pay_gateway_sections', array( $this, 'sections' ) );
		add_filter( 'pronamic_pay_gateway_fields', array( $this, 'fields' ) );
	}

	public function sections( array $sections ) {
		// iDEAL
		$sections['mollie_ideal'] = array(
			'title'   => __( 'Mollie iDEAL', 'pronamic_ideal' ),
			'methods' => array( 'mollie_ideal' ),
		);

		return $sections;
	}

	public function fields( array $fields ) {
		// Partner ID
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'mollie_ideal',
			'meta_key'    => '_pronamic_gateway_mollie_partner_id',
			'title'       => __( 'Partner ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
			'description' => __( 'Mollie.nl accountnummer. Op het gespecificeerde account wordt na succesvolle betaling tegoed bijgeschreven.', 'pronamic_ideal' ),
			'methods'     => array( 'mollie_ideal' ),
		);

		// Profile Key
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'mollie_ideal',
			'meta_key'    => '_pronamic_gateway_mollie_profile_key',
			'title'       => __( 'Profile Key', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'regular-text', 'code' ),
			'description' => sprintf(
				__( 'Hiermee kunt u een ander websiteprofielen selecteren om uw betaling aan te linken. Gebruik de waarde uit het veld Key uit het profiel overzicht. [<a href="%s" target="_blank">bekijk overzicht van uw profielen</a>].', 'pronamic_ideal' ),
				'https://www.mollie.nl/beheer/account/profielen/'
			),
			'methods'     => array( 'mollie_ideal' ),
		);

		return $fields;
	}
}
