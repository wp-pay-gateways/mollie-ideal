<?php

/**
 * Title: Mollie iDEAL integration
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.1.0
 * @since 1.1.0
 */
class Pronamic_WP_Pay_Gateways_Mollie_IDeal_Integration extends Pronamic_WP_Pay_Gateways_AbstractIntegration {
	public function __construct() {
		$this->id            = 'mollie-ideal';
		$this->name          = 'Mollie - iDEAL';
		$this->dashboard_url = 'http://www.mollie.nl/';
		$this->provider      = 'mollie';
		$this->deprecated    = true;
	}

	public function get_config_factory_class() {
		return 'Pronamic_WP_Pay_Gateways_Mollie_IDeal_ConfigFactory';
	}

	public function get_config_class() {
		return 'Pronamic_WP_Pay_Gateways_Mollie_IDeal_Config';
	}

	public function get_settings_class() {
		return 'Pronamic_WP_Pay_Gateways_Mollie_IDeal_Settings';
	}

	public function get_gateway_class() {
		return 'Pronamic_WP_Pay_Gateways_Mollie_IDeal_Gateway';
	}
}
