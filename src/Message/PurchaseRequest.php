<?php

namespace Omnipay\Tithely\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Purchase Request
 *
 * @method Response send()
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Validate the currency.
     *
     * This method checks a currency against the Tithe.ly organization's
     * bank account configuration.
     *
     * @param string $currency
     * @throws InvalidRequestException
     */
    private function validateCurrency($currency)
    {
        $organization = $this->getOrganization();
        $data = $organization->getData();

        if (!isset($data['object']['bank']['currency'])) {
            throw new InvalidRequestException('Could not fetch organization.');
        }

        if ($data['object']['bank']['currency'] != $currency) {
            throw new InvalidRequestException('The organization does not support payments made in ' . $currency . '.');
        }
    }

    public function getData()
    {
        $this->validate('token', 'amount', 'currency', 'card');
        $this->validateCurrency($this->getCurrency());

        $data = array(
            'first_name' => $this->getCard()->getFirstName(),
            'last_name' => $this->getCard()->getLastName(),
            'email' => $this->getCard()->getEmail(),
            'token' => $this->getParameter('token'),
            'organization_id' => $this->getOrganizationId(),
            'amount' => $this->getAmountInteger(),
            'giving_type' => $this->getGivingType()
        );

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/charge-once';
    }
}
