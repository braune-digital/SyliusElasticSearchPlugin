<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\Controller\ProductListView;
use Sylius\ElasticSearchPlugin\Controller\ViewInterface;

interface ListViewFactoryInterface
{
    /**
     * @param SearchResponse $response
     *
     * @return ProductListView
     */
    public function createFromSearchResponse(SearchResponse $response, $listViewClass): ViewInterface;
}
