<?php

namespace Pronamic\WordPress\Pay\Gateways\MollieIDeal;

/**
 * Title: Mollie iDEAL actions constants
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @see     https://www.mollie.nl/support/documentatie/betaaldiensten/ideal/en/
 */
class Actions {
	/**
	 * Check
	 *
	 * @var string
	 */
	const CHECK = 'check';

	/**
	 * Fetch
	 *
	 * @var string
	 */
	const FETCH = 'fetch';

	/**
	 * Bank list
	 *
	 * @var string
	 */
	const BANK_LIST = 'banklist';
}
