<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\View;

use Doctrine\Common\Collections\ArrayCollection;
use ONGR\FilterManagerBundle\Filter\ViewData;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ExclusionPolicy("all")
 */
class ListView implements ViewInterface
{
    /**
     * @var int
     * @Expose
     * @Groups({"Search"})
     */
    protected $page;

    /**
     * @var int
     * @Expose
     * @Groups({"Search"})
     */
    protected $limit;

    /**
     * @var int
     * @Expose
     * @Groups({"Autocomplete", "Search"})
     */
    protected $total;

    /**
     * @var int
     * @Expose
     * @Groups({"Search"})
     */
    protected $pages;

    /**
     * @var ArrayCollection
     * @Expose
     * @Groups({"Search"})
     */
    protected $items;

    /**
     * @var ViewData[]
     * @Expose
     * @Groups({"Search"})
     */
    protected $filters;

    /**
     * ListView constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @param int $pages
     */
    public function setPages(int $pages): void
    {
        $this->pages = $pages;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems(): ArrayCollection
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection $items
     */
    public function setItems(ArrayCollection $items): void
    {
        $this->items = $items;
    }

    /**
     * @return ViewData[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param ViewData[] $filters
     */
    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function addItem($item) {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }
    }

}
