<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Filter\Widget;

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\Widget\Choice\SingleTermChoice as BaseSingleTermChoice;
use ONGR\FilterManagerBundle\Search\SearchRequest;

/**
 * This class provides single terms choice.
 */
class SingleTermChoice extends BaseSingleTermChoice
{

    /**
     * {@inheritdoc}
     */
    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null)
    {
        $boolType = BoolQuery::MUST;

        if ($this->hasOption('operator') && in_array($this->getOption('operator'), ['and', 'or'])) {
            switch ($this->getOption('operator')) {
                case 'or':
                    $boolType = BoolQuery::SHOULD;
                    break;
            }
        }
        if ($state && $state->isActive()) {
            $search->addPostFilter(new TermQuery($this->getDocumentField(), $state->getValue()), $boolType);
        }
    }
}
