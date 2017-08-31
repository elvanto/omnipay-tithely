<?php

namespace Omnipay\Tithely;

use Omnipay\Common\AbstractGateway;

/**
 * Tithely Gateway
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Tithely';
    }

    public function getDefaultParameters()
    {
        return array(
            'publicKey' => '',
            'privateKey' => '',
            'organizationId' => '',
            'givingType' => '',
            'testMode' => false,
        );
    }

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

    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\Tithely\Message\PurchaseRequest', $options);
    }
}
