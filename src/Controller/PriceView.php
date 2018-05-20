<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Controller;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ExclusionPolicy("all")
 */
class PriceView implements ViewInterface
{
    /**
     * @var int
     * @Expose
     * @Groups({"search"})
     */
    public $current;

    /**
     * @var string
     * @Expose
     * @Groups({"search"})
     */
    public $currency;

    /**
     * @var int
     * @Expose
     * @Groups({"search"})
     */
    public $original;
}
