<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\View;

use Doctrine\Common\Collections\ArrayCollection;

interface ViewInterface {

    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @param int $page
     */
    public function setPage(int $page): void;

    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void;

    /**
     * @return int
     */
    public function getTotal(): int;

    /**
     * @param int $total
     */
    public function setTotal(int $total): void;

    /**
     * @return int
     */
    public function getPages(): int;

    /**
     * @param int $pages
     */
    public function setPages(int $pages): void;

    /**
     * @return ArrayCollection
     */
    public function getItems(): ArrayCollection;

    /**
     * @param ArrayCollection $items
     */
    public function setItems(ArrayCollection $items): void;

    /**
     * @return ViewData[]
     */
    public function getFilters(): array;

    /**
     * @param ViewData[] $filters
     */
    public function setFilters(array $filters): void;

    public function addItem($item);

}
