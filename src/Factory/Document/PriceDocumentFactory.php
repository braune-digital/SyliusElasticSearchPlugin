<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\Document;

use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Currency\Model\CurrencyInterface;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;

final class PriceDocumentFactory implements PriceDocumentFactoryInterface
{
    /**
     * @var string
     */
    private $priceDocumentClass;

    public function __construct(string $priceDocumentClass)
    {
        $this->priceDocumentClass = $priceDocumentClass;
    }

    public function create(
        ChannelPricingInterface $channelPricing,
        CurrencyInterface $currency
    ): PriceDocument {
        /** @var PriceDocument $price */
        $price = new $this->priceDocumentClass();
        $originalAmount = $channelPricing->getOriginalPrice();

        $price->setAmount($channelPricing->getPrice());
        $price->setCurrency($currency->getCode());
        $price->setOriginalAmount(null !== $originalAmount && $originalAmount > 0 ? $originalAmount : 0);
        $price->setVariantCode($channelPricing->getProductVariant()->getCode());

        return $price;
    }
}
