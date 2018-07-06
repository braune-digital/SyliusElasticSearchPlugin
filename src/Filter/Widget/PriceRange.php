<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Filter\Widget;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\ViewData;
use ONGR\FilterManagerBundle\Filter\Widget\Range\Range;
use ONGR\FilterManagerBundle\Search\SearchRequest;
use Symfony\Component\HttpFoundation\Request;
use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;


/**
 * Class PriceRange
 * @package Sylius\ElasticSearchPlugin\Filter\Widget
 */
class PriceRange extends Range
{
    /**
     * @param Search $search
     * @param FilterState|null $state
     * @param SearchRequest|null $request
     */
    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null)
    {
        $postFilter = $this->getOption('postFilter', false);
        $method = ($postFilter) ? 'addPostFilter': 'addQuery';
        if ($state && $state->isActive()) {
            $filter = new RangeQuery($this->getDocumentField(), $state->getValue());
            $search->$method($filter);
        }
    }

}
