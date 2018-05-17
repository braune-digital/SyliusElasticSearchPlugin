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
     * @Groups({"autocomplete"})
     */
    public $page;

    /**
     * @var int
     * @Expose
     * @Groups({"autocomplete"})
     */
    public $limit;

    /**
     * @var int
     * @Expose
     * @Groups({"autocomplete"})
     */
    public $total;

    /**
     * @var int
     * @Expose
     * @Groups({"autocomplete"})
     */
    public $pages;

    /**
     * @var ProductView[]
     * @Expose
     * @Groups({"autocomplete"})
     */
    public $items = [];

    /**
     * @var ViewData[]
     * @Expose
     * @Groups({"autocomplete"})
     */
    public $filters;
}
