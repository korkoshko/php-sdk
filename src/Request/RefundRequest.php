<?php

namespace WayForPay\SDK\Request;

use WayForPay\SDK\Credential\AccountSecretCredential;
use WayForPay\SDK\Response\RufundResponse;

/**
 * Class RefundRequest
 * @package WayForPay\SDK\Request
 * @method RufundResponse send()
 */
class RefundRequest extends ApiRequest
{
    /**
     * @var string
     */
    private $orderReference;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $comment;

    public function __construct(
        AccountSecretCredential $credential,
        $orderReference,
        $amount,
        $currency,
        $comment
    ) {
        parent::__construct($credential);

        $this->orderReference = $orderReference;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->comment = $comment;
    }

    public function getRequestSignatureFieldsRequired()
    {
        return array_merge(parent::getRequestSignatureFieldsRequired(), array(
            'orderReference',
            'amount',
            'currency'
        ));
    }

    public function getRequestSignatureFieldsValues($charset = self::DEFAULT_CHARSET)
    {
        return array_merge(parent::getRequestSignatureFieldsValues($charset), array(
            'orderReference' => $this->orderReference,
            'amount' => $this->amount,
            'currency' => $this->currency
        ));
    }

    public function getResponseSignatureFieldsRequired()
    {
        return array(
            'merchantAccount',
            'orderReference',
            'transactionStatus',
            'reasonCode',
        );
    }

    public function getTransactionType()
    {
        return 'REFUND';
    }

    public function getTransactionData()
    {
        return array_merge(parent::getTransactionData(), array(
            'orderReference' => $this->orderReference,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'comment' => $this->comment
        ));
    }

    public function getResponseClass()
    {
        return RufundResponse::getClass();
    }
}