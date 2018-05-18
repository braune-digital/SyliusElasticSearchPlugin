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
class ProductListView implements ViewInterface
{
    /**
     * @var int
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $page;

    /**
     * @var int
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $limit;

    /**
     * @var int
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $total;

    /**
     * @var int
     * @Expose
     * @Groups({"autocomplete", "search"})
     */
    public $pages;

    /**
     * @var ProductView[]
     * @Expose
     * @Groups({"search"})
     */
    public $items = [];

    /**
     * @var ViewData[]
     * @Expose
     * @Groups({"search"})
     */
    public $filters;
}
