<?php

namespace Pronamic\WordPress\Pay\Gateways\MollieIDeal;

use Pronamic\WordPress\Pay\Core\Statuses as Core_Statuses;

/**
 * Title: Mollie iDEAL statuses constants
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @see     https://www.mollie.nl/support/documentatie/betaaldiensten/ideal/en/
 */
class Statuses {
	/**
	 * Success
	 *
	 * @var string
	 */
	const SUCCESS = 'Success';

	/**
	 * Cancelled
	 *
	 * @var string
	 */
	const CANCELLED = 'Cancelled';

	/**
	 * Expired
	 *
	 * @var string
	 */
	const EXPIRED = 'Expired';

	/**
	 * Failure
	 *
	 * @var string
	 */
	const FAILURE = 'Failure';

	/**
	 * Checked before
	 *
	 * @var string
	 */
	const CHECKED_BEFORE = 'CheckedBefore';

	/**
	 * Transform an Mollie state to an more global status
	 *
	 * @param string $status Status.
	 */
	public static function transform( $status ) {
		switch ( $status ) {
			case self::SUCCESS:
				return Core_Statuses::SUCCESS;

			case self::CANCELLED:
				return Core_Statuses::CANCELLED;

			case self::EXPIRED:
				return Core_Statuses::EXPIRED;

			case self::FAILURE:
				return Core_Statuses::FAILURE;

			case self::CHECKED_BEFORE:
				return null;

			default:
				return null;
		}
	}
}
