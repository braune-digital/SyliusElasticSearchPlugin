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
     * @Groups({"autocomplete"})
     */
    public $id;

    /**
     * @var string
     * @Expose
     * @Groups({"autocomplete"})
     */
    public $code;

    /**
     * @var string
     * @Expose
     * @Groups({"autocomplete"})
     */
    public $name;

    /**
     * @var string
     * @Expose
     * @Groups({"autocomplete"})
     */
    public $slug;

    /**
     * @var array
     */
    public $taxons = [];

    /**
     * @var array
     */
    public $variants = [];

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var array
     */
    public $images = [];

    /**
     * @var PriceView
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
     */
    public $mainTaxon;

    /**
     * @var float
     */
    public $rating;
}
