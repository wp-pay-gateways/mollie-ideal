<?php

/**
 * Title: Mollie iDEAL statuses constants
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @see https://www.mollie.nl/support/documentatie/betaaldiensten/ideal/en/
 */
class Pronamic_WP_Pay_Gateways_Mollie_IDeal_Statuses {
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

	/////////////////////////////////////////////////

	/**
	 * Transform an Mollie state to an more global status
	 *
	 * @param string $status
	 */
	public static function transform( $status ) {
		switch ( $status ) {
			case self::SUCCESS :
				return Pronamic_WP_Pay_Statuses::SUCCESS;
			case self::CANCELLED :
				return Pronamic_WP_Pay_Statuses::CANCELLED;
			case self::EXPIRED :
				return Pronamic_WP_Pay_Statuses::EXPIRED;
			case self::FAILURE :
				return Pronamic_WP_Pay_Statuses::FAILURE;
			case self::CHECKED_BEFORE :
				return null;
			default:
				return null;
		}
	}
}
