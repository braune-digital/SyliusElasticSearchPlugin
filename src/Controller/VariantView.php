<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Controller;

use ONGR\FilterManagerBundle\Filter\ViewData;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ExclusionPolicy("all")
 */
class VariantView implements ViewInterface
{
    /**
     * @var int
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $id;

    /**
     * @var string
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $code;

    /**
     * @var string
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $name;

    /**
     * @var PriceView
     */
    public $price;

    /**
     * @var int
     */
    public $stock;

    /**
     * @var int
     */
    public $isTracked;

    /**
     * @var ImageView[]
     */
    public $images = [];
}
