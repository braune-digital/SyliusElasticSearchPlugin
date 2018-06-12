<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Filter\Widget;

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\Widget\Choice\MultiTermChoice as BaseMultiTermChoice;
use ONGR\FilterManagerBundle\Search\SearchRequest;

/**
 * This class provides single terms choice.
 */
class MultiTermChoice extends BaseMultiTermChoice
{

    /**
     * {@inheritdoc}
     */
    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null)
    {
        if ($state && $state->isActive()) {
            $boolType = BoolQuery::MUST;

            if ($this->hasOption('operator') && in_array($this->getOption('operator'), ['and', 'or'])) {
                switch ($this->getOption('operator')) {
                    case 'or':
                        $boolType = BoolQuery::SHOULD;
                        break;
                }
            }
            $filter = new TermsQuery($this->getDocumentField(), $state->getValue());
            $search->addPostFilter($filter);
        }
    }
}
