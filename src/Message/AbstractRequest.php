<?php

namespace Omnipay\Tithely\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request
 *
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $liveEndpoint = 'https://tithe.ly/api/v1';
    protected $testEndpoint = 'https://tithelydev.com/api/v1';

    public function getPublicKey()
    {
        return $this->getParameter('publicKey');
    }

    public function setPublicKey($value)
    {
        return $this->setParameter('publicKey', $value);
    }

    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    public function getOrganizationId()
    {
        return $this->getParameter('organizationId');
    }

    public function setOrganizationId($value)
    {
        return $this->setParameter('organizationId', $value);
    }

    public function getGivingType()
    {
        return $this->getParameter('givingType');
    }

    public function setGivingType($value)
    {
        return $this->setParameter('givingType', $value);
    }

    public function sendData($data)
    {
        $url = $this->getEndpoint();
        $httpResponse = $this->httpClient->request(
        'POST',
            $url,
            [],
            json_encode(
                array_merge(
                    ['auth' => [$this->getPublicKey(), $this->getPrivateKey()]],
                    $data
                )
            )
        );

        return $this->createResponse(json_decode($httpResponse->getBody()->getContents(), true));
    }

    public function getOrganization()
    {
        $url = $this->getEndpoint() . '/organizations/' . $this->getOrganizationId();
        $httpResponse = $this->httpClient->request(
            'GET',
            $url,
            [],
            json_encode([
                'auth' => [$this->getPublicKey(), $this->getPrivateKey()]
            ])
        );

        return $this->createResponse(json_decode($httpResponse->getBody()->getContents(), true));
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
