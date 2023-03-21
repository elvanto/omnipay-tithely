# Omnipay: Tithely

**Tithe.ly driver for the Omnipay payment processing library**

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elvanto/omnipay-tithely.svg?style=flat-square)](https://packagist.org/packages/elvanto/omnipay-tithely)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/elvanto/omnipay-tithely/master.svg?style=flat-square)](https://travis-ci.org/elvanto/omnipay-tithely)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/elvanto/omnipay-tithely.svg?style=flat-square)](https://scrutinizer-ci.com/g/elvanto/omnipay-tithely/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/elvanto/omnipay-tithely.svg?style=flat-square)](https://scrutinizer-ci.com/g/elvanto/omnipay-tithely)
[![Total Downloads](https://img.shields.io/packagist/dt/elvanto/omnipay-tithely.svg?style=flat-square)](https://packagist.org/packages/elvanto/omnipay-tithely)


[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.6+. This package implements Tithe.ly support for Omnipay.

## Install

Via Composer

``` bash
$ composer require elvanto/omnipay-tithely
```

## Versions

Omnipay 3.x is supported starting with v2.0.0 of this package.

## Usage

The following gateways are provided by this package:

 * Tithe.ly (Quick Charge)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.

### Specific Usage Instructions 

Omnipay tithely is an API middleware to simplify requests to [Tithely Quick-Charge v1](https://docs.tithe.ly/reference/quick-charge) and later V2. This Tithely api allows users to create a payment request without creating an account. 

### Creating the payment request.

#### Tithely Payment Gateway
Validation data like our *tithely organisation id* `tithely_org_Id`, *tithely public `tithely_public` and secret `tithely_secret` keys* exist as part of our gateway request. Additionally the gateway also takes our *giving type* `giving_type` field as a string.

The gateway details are set with the functions: 
```php
$gateway->setPublicKey($tithely_public);  // Required
$gateway->setPrivateKey($tithely_secret);  // Required
$gateway->setOrganizationId($tithely_org_Id);   // Required
$gateway->setGivingType("Offering");  // Required
```

#### Request Body
Unlike regular use of the tithely quick charge api, the omnipay/tithely api object requires a *card* object within the request to pass our `first_name`, `last_name`, and `email`. The `token`, `description`, `currency` and exist in request objects main body.

Specific to omnipay / tithely the `currency` field within the `$request` body is required.

```php
$request["card"] =  new CreditCard(array(  
    "first_name" => $first_name,   // Required
    "last_name" => $last_name,   // Required
    "email" => $email   // Required
));  
  
$request["token"] = $token; // Stripe token. Required
$request["amount"] = "10.00";  // Required
$request["description"] = "Donation to church.";
$request["currency"] = $currency; //e.g. "USD" "CAD" "AUD" Required

$gateway = Omnipay::create('Tithely');

$tithely_public = "pub_*****"; // Required
$tithely_secret = "pri_*****"; // Required
$tithely_org_Id = "org_*****"; // Required

$gateway->setPublicKey($tithely_public);  // Required
$gateway->setPrivateKey($tithely_secret);  // Required
$gateway->setOrganizationId($tithely_org_Id);   // Required
$gateway->setGivingType("Offering");  // Required

$response = $gateway->purchase($request)->send();
```

### Accessing the response object.

The `$reponse` comes as a protected object. To access the response use the `getRequest` and `getData()` odadmnipay functions.

```php
$response->getRequest()->getData()["first_name"];
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/elvanto/omnipay-tithely/issues),
or better yet, fork the library and submit a pull request.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email developers@elvanto.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
