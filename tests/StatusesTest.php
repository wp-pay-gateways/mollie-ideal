<?php
use Pronamic\WordPress\Pay\Core\Statuses;
use Pronamic\WordPress\Pay\Gateways\Mollie_IDeal\Statuses;

/**
 * Title: Mollie iDEAL statuses constants tests
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @see https://www.mollie.nl/support/documentatie/betaaldiensten/ideal/en/
 */
class Pronamic_WP_Pay_Gateways_Mollie_IDeal_StatusesTest extends PHPUnit_Framework_TestCase {
	/**
	 * Transform test
	 *
	 * @dataProvider status_matrix_provider
	 */
	public function test_transform( $mollie_status, $expected ) {
		$status = Statuses::transform( $mollie_status );

		$this->assertEquals( $expected, $status );
	}

	public function status_matrix_provider() {
		return array(
			array( Statuses::SUCCESS, Statuses::SUCCESS ),
			array( Statuses::CANCELLED, Statuses::CANCELLED ),
			array( Statuses::EXPIRED, Statuses::EXPIRED ),
			array( Statuses::FAILURE, Statuses::FAILURE ),
			array( Statuses::CHECKED_BEFORE, null ),
			array( 'not existing status', null ),
		);
	}
}
