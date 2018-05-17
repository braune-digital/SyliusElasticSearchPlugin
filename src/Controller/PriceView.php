<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Controller;

class PriceView implements ViewInterface
{
    /**
     * @var int
     */
    public $current;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var int
     */
    public $original;
}
