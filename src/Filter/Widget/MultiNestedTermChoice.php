<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Filter\Widget;

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\Widget\Choice\MultiTermChoice;
use ONGR\FilterManagerBundle\Filter\Widget\Choice\SingleTermChoice;
use ONGR\FilterManagerBundle\Search\SearchRequest;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermsQuery;

/**
 * This class provides multi terms choice.
 */
class MultiNestedTermChoice extends MultiTermChoice
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

            [$path, $field] = explode('>', $this->getDocumentField());
            $postFilter = $this->getOption('postFilter', false);
            $method = ($postFilter) ? 'addPostFilter' : 'addQuery';

            $search->$method(
                new NestedQuery(
                    $path,
                    new TermsQuery($field, $state->getValue())
                ),
                $boolType
            );
        }
    }

}
