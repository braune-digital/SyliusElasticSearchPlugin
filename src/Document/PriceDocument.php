<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Document;

use ONGR\ElasticsearchBundle\Annotation as ElasticSearch;

/**
 * @ElasticSearch\Object
 */
class PriceDocument implements DocumentInterface
{
    /**
     * @var int
     *
     * @ElasticSearch\Property(type="integer")
     */
    protected $amount;

    /**
     * @var int
     *
     * @ElasticSearch\Property(type="integer")
     */
    protected $originalAmount = 0;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $currency;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $variantCode;

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getOriginalAmount(): int
    {
        return $this->originalAmount;
    }

    /**
     * @param int $originalAmount
     */
    public function setOriginalAmount(int $originalAmount = 0): void
    {
        $this->originalAmount = $originalAmount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getVariantCode(): string {
        return $this->variantCode;
    }

    /**
     * @param string $variantCode
     */
    public function setVariantCode(string $variantCode): void {
        $this->variantCode = $variantCode;
    }

    

}
