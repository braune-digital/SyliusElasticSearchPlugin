<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\Controller\ProductListView;
use Sylius\ElasticSearchPlugin\View\ViewInterface;

interface ListViewFactoryInterface
{
    /**
     * @param SearchResponse $response
     * @param string $entityClass
     * @param string $identifierProperty
     * @return ViewInterface
     */
    public function createFromSearchResponse(SearchResponse $response, string $entityClass, string $identifierProperty): ViewInterface;
}
