<?php

namespace Pronamic\WordPress\Pay\Gateways\MollieIDeal;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: Mollie iDEAL config
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Config extends GatewayConfig {
	public $partner_id;

	public $profile_key;
}
