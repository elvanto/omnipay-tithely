<?php

namespace Omnipay\Tithely\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        if (isset($this->data['status'])) {
            return $this->data['status'] === 'success';
        }

        return false;
    }

    public function getTransactionReference()
    {
        if (isset($this->data['charge_id'])) {
            return $this->data['charge_id'];
        }
    }

    public function getMessage()
    {
        if (isset($this->data['reason'])) {
            return $this->data['reason'];
        }
    }
}
