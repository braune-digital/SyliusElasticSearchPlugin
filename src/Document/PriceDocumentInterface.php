<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Document;

interface PriceDocumentInterface extends DocumentInterface
{

    public function getAmount(): int;

    public function setAmount(int $amount): void;

    /**
     * @return int
     */
    public function getOriginalAmount(): int;

    /**
     * @param int $originalAmount
     */
    public function setOriginalAmount(int $originalAmount = 0): void;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void;

    /**
     * @return string
     */
    public function getVariantCode(): string;

    /**
     * @param string $variantCode
     */
    public function setVariantCode(string $variantCode): void;

    

}
