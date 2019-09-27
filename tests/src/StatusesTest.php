<?php

namespace Pronamic\WordPress\Pay\Gateways\MollieIDeal;

use Pronamic\WordPress\Pay\Payments\PaymentStatus as CoreStatuses;

/**
 * Title: Mollie iDEAL statuses constants tests
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @see     https://www.mollie.nl/support/documentatie/betaaldiensten/ideal/en/
 */
class StatusesTest extends \PHPUnit_Framework_TestCase {
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
			array( Statuses::SUCCESS, CoreStatuses::SUCCESS ),
			array( Statuses::CANCELLED, CoreStatuses::CANCELLED ),
			array( Statuses::EXPIRED, CoreStatuses::EXPIRED ),
			array( Statuses::FAILURE, CoreStatuses::FAILURE ),
			array( Statuses::CHECKED_BEFORE, null ),
			array( 'not existing status', null ),
		);
	}
}
