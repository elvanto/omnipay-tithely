<?php

namespace Omnipay\Tithely;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\Common\CreditCard;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'token' => 'tok_1At7W5IQNdBF7J9fCdDS0Shu',
            'currency' => 'AUD',
            'card' => new CreditCard(array(
                'firstName' => 'Example',
                'lastName' => 'User',
                'email' => 'example@user.com'
            )),
        );
    }

    public function testPurchase()
    {
        $this->setMockHttpResponse(array('Organization.txt', 'PurchaseSuccess.txt'));

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('ch_HYPFilaqVuA', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }
}
