<?php

namespace Sylius\ElasticSearchPlugin\Event;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use Sylius\ElasticSearchPlugin\Document\DocumentInterface;
use Symfony\Component\EventDispatcher\Event;

class ResultViewEvent extends Event
{

    CONST RESULT_VIEW = 'sylius.elasticsearch.result_view';

    /**
     * @var array
     */
    private $raw;

    /**
     * @var DocumentInterface
     */
    private $result;

    /**
     * ResultViewEvent constructor.
     * @param array $raw
     * @param DocumentInterface $result
     */
    public function __construct(array $raw, DocumentInterface $result)
    {
        $this->raw = $raw;
        $this->result = $result;
    }

    /**
     * @return array
     */
    public function getRaw(): ?array
    {
        return $this->raw;
    }

    /**
     * @return DocumentInterface
     */
    public function getResult():?DocumentInterface
    {
        return $this->result;
    }

}
