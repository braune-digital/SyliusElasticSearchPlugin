<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Filter\Widget;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\ElasticsearchDSL\Aggregation\Metric\StatsAggregation;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\Geo\GeoDistanceQuery;
use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\ViewData;
use ONGR\FilterManagerBundle\Filter\Widget\AbstractFilter;
use ONGR\FilterManagerBundle\Filter\Widget\Dynamic\DynamicAggregate;
use ONGR\FilterManagerBundle\Filter\Widget\Range\AbstractRange;
use ONGR\FilterManagerBundle\Search\SearchRequest;
use Symfony\Component\HttpFoundation\Request;


class GeoDistance extends AbstractFilter
{

    /**
     * {@inheritdoc}
     */
    public function getState(Request $request)
    {
        $state = new FilterState();
        $value = $request->get($this->getRequestField());

        if (isset($value) && $value !== '') {
            $state->setActive(true);
            $state->setValue($value);
        }

        if (!$state->isActive()) {
            return $state;
        }

        return $state;
    }

    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null)
    {
        $this->modifySearchQuery($search, $state, $request, 'location', ['lat' => 40, 'lon' => -70]);

    }

    /**
     * @param Search $search
     * @param FilterState|null $state
     * @param SearchRequest|null $request
     */
    public function modifySearchQuery(Search $search, FilterState $state = null, SearchRequest $request = null, $field = null, $geoPoint = null)
    {
        if ($state && $state->isActive()) {
            if (is_array($state->getValue()) && isset($state->getValue()['radius'])) {
                $radius = $state->getValue()['radius'];
            } else {
                $radius = $this->getOption('radius', 2);
            }
            $boolQuery = new BoolQuery();
            $boolQuery->add(new MatchAllQuery());
            $geoQuery = new GeoDistanceQuery($field, $radius, $geoPoint);
            $boolQuery->add($geoQuery, BoolQuery::MUST);
            $search->addQuery($boolQuery);
        }
    }

    public function preProcessSearch(Search $search, Search $relatedSearch, FilterState $state = null)
    {
        // TODO: Implement preProcessSearch() method.
    }

    public function getViewData(DocumentIterator $result, ViewData $data)
    {
        // TODO: Implement getViewData() method.
    }

}
