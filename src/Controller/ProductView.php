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
class ProductView implements ViewInterface
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
     * @var string
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $slug;

    /**
     * @var array
     */
    public $taxons = [];


    /**
     * @var array
     * @Expose
     * @Groups({"search"})
     */
    public $variants = [];

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var array
     * @Expose
     * @Groups({"search"})
     */
    public $images = [];

    /**
     * @var PriceView
     * @Expose
     * @Groups({"search"})
     */
    public $price;

    /**
     * @var string
     */
    public $channelCode;

    /**
     * @var string
     */
    public $localeCode;

    /**
     * @var array
     * @Expose
     * @Groups({"search"})
     */
    public $mainTaxon;

    /**
     * @var float
     */
    public $rating;
}
