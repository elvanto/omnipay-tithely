<?php

namespace Omnipay\Tithely\Message;

use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testPurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $response = new Response($this->getMockRequest(), json_decode($httpResponse->getBody()->getContents(), true));

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('ch_HYPFilaqVuA', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }
}
