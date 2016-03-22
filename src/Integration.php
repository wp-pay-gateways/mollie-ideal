<?php

/**
 * Title: Mollie iDEAL integration
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.5
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_Mollie_IDeal_Integration extends Pronamic_WP_Pay_Gateways_AbstractIntegration {
	public function __construct() {
		$this->id            = 'mollie-ideal';
		$this->name          = 'Mollie - iDEAL';
		$this->dashboard_url = 'http://www.mollie.nl/beheer/';
		$this->provider      = 'mollie';
		$this->deprecated    = true;
	}

	public function get_config_factory_class() {
		return 'Pronamic_WP_Pay_Gateways_Mollie_IDeal_ConfigFactory';
	}

	public function get_settings_class() {
		return 'Pronamic_WP_Pay_Gateways_Mollie_IDeal_Settings';
	}

	/**
	 * Get required settings for this integration.
	 *
	 * @see https://github.com/wp-premium/gravityforms/blob/1.9.16/includes/fields/class-gf-field-multiselect.php#L21-L42
	 * @since 1.0.4
	 * @return array
	 */
	public function get_settings() {
		$settings = parent::get_settings();

		$settings[] = 'mollie_ideal';

		return $settings;
	}
}
