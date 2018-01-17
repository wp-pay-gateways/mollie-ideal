<?php

/**
 * Title: Mollie iDEAL actions constants tests
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @see https://www.mollie.nl/support/documentatie/betaaldiensten/ideal/en/
 */
class Pronamic_WP_Pay_Gateways_Mollie_IDeal_ActionsTest extends PHPUnit_Framework_TestCase {
	/**
	 * Test actions
	 *
	 * @dataProvider actions_matrix_provider
	 */
	public function test_actions( $action, $expected ) {
		$this->assertEquals( $expected, $action );
	}

	public function actions_matrix_provider() {
		return array(
			array( Pronamic_WP_Pay_Gateways_Mollie_IDeal_Actions::CHECK, 'check' ),
			array( Pronamic_WP_Pay_Gateways_Mollie_IDeal_Actions::FETCH, 'fetch' ),
			array( Pronamic_WP_Pay_Gateways_Mollie_IDeal_Actions::BANK_LIST, 'banklist' ),
		);
	}
}
