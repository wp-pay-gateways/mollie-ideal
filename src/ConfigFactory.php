<?php

namespace Pronamic\WordPress\Pay\Gateways\Mollie_IDeal;

use Pronamic\WordPress\Pay\Core\GatewayConfigFactory;

/**
 * Title: Mollie iDEAL config factory
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class ConfigFactory extends GatewayConfigFactory {
	public function get_config( $post_id ) {
		$config = new Config();

		$config->partner_id  = get_post_meta( $post_id, '_pronamic_gateway_mollie_partner_id', true );
		$config->profile_key = get_post_meta( $post_id, '_pronamic_gateway_mollie_profile_key', true );

		$config->mode = get_post_meta( $post_id, '_pronamic_gateway_mode', true );

		return $config;
	}
}
