# [DEPRECATED] WordPress Pay Gateway: Mollie iDEAL

**Mollie iDEAL driver for the WordPress payment processing library.**

[![Build Status](https://travis-ci.org/wp-pay-gateways/mollie-ideal.svg?branch=develop)](https://travis-ci.org/wp-pay-gateways/mollie-ideal)
[![Coverage Status](https://coveralls.io/repos/wp-pay-gateways/mollie-ideal/badge.svg?branch=master&service=github)](https://coveralls.io/github/wp-pay-gateways/mollie-ideal?branch=master)
[![Latest Stable Version](https://poser.pugx.org/wp-pay-gateways/mollie-ideal/v/stable.svg)](https://packagist.org/packages/wp-pay-gateways/mollie-ideal)
[![Total Downloads](https://poser.pugx.org/wp-pay-gateways/mollie-ideal/downloads.svg)](https://packagist.org/packages/wp-pay-gateways/mollie-ideal)
[![Latest Unstable Version](https://poser.pugx.org/wp-pay-gateways/mollie-ideal/v/unstable.svg)](https://packagist.org/packages/wp-pay-gateways/mollie-ideal)
[![License](https://poser.pugx.org/wp-pay-gateways/mollie-ideal/license.svg)](https://packagist.org/packages/wp-pay-gateways/mollie-ideal)
[![Built with Grunt](https://cdn.gruntjs.com/builtwith.svg)](http://gruntjs.com/)

## Documentation

*	[Mollie iDEAL API](https://www.mollie.nl/support/documentatie/betaaldiensten/ideal/)

## Development environment

If you want to test Mollie iDEAL on a development environment wich is not 
accessible for Mollie you might get the following error:

> -3 A fetch was issued without (proper) specification of 'reporturl'

To fix this issue you can override the Mollie 'reporturl' parameter by 
the following configuration constant:

```
define( 'MOLLIE_IDEAL_REPORT_URL', 'http://www.example.com/' );
```

You can put this in your WordPress configuration file and you should be good
to go.
