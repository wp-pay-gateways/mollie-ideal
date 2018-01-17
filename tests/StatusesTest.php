<?php

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
		$status = Pronamic_WP_Pay_Gateways_Mollie_IDeal_Statuses::transform( $mollie_status );

		$this->assertEquals( $expected, $status );
	}

	public function status_matrix_provider() {
		return array(
			array( Pronamic_WP_Pay_Gateways_Mollie_IDeal_Statuses::SUCCESS, Pronamic_WP_Pay_Statuses::SUCCESS ),
			array( Pronamic_WP_Pay_Gateways_Mollie_IDeal_Statuses::CANCELLED, Pronamic_WP_Pay_Statuses::CANCELLED ),
			array( Pronamic_WP_Pay_Gateways_Mollie_IDeal_Statuses::EXPIRED, Pronamic_WP_Pay_Statuses::EXPIRED ),
			array( Pronamic_WP_Pay_Gateways_Mollie_IDeal_Statuses::FAILURE, Pronamic_WP_Pay_Statuses::FAILURE ),
			array( Pronamic_WP_Pay_Gateways_Mollie_IDeal_Statuses::CHECKED_BEFORE, null ),
			array( 'not existing status', null ),
		);
	}
}
