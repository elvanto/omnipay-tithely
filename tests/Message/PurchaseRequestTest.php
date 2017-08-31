<?php

namespace Omnipay\Tithely\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '10.00',
                'token' => 'tok_1At7W5IQNdBF7J9fCdDS0Shu',
                'currency' => 'AUD',
                'card' => array(
                    'firstName' => 'Example',
                    'lastName' => 'User',
                    'email' => 'example@user.com'
                )
            )
        );
    }

    public function testGetData()
    {
        $this->setMockHttpResponse('Organization.txt');
        $data = $this->request->getData();

        $this->assertEquals('Example', $data['first_name']);
        $this->assertEquals('User', $data['last_name']);
        $this->assertEquals('example@user.com', $data['email']);
        $this->assertEquals(1000, $data['amount']);
        $this->assertEquals('tok_1At7W5IQNdBF7J9fCdDS0Shu', $data['token']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse(array('Organization.txt', 'PurchaseSuccess.txt'));
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('ch_HYPFilaqVuA', $response->getTransactionReference());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse(array('Organization.txt', 'PurchaseFailure.txt'));
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('There was a problem using that payment method. Please try again in a few minutes.', $response->getMessage());
    }
}
