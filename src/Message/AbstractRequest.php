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
        $httpResponse = $this->httpClient->post(
            $url,
            null,
            $data,
            array(
                'auth' => array($this->getPublicKey(), $this->getPrivateKey())
            )
        )->send();

        return $this->createResponse($httpResponse->json());
    }

    public function getOrganization()
    {
        $httpResponse = $this->httpClient->get(
            self::getEndpoint() . '/organizations/' . $this->getOrganizationId(),
            null,
            array(
                'auth' => array($this->getPublicKey(), $this->getPrivateKey())
            )
        )->send();

        return $this->createResponse($httpResponse->json());
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
