<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Event;

use Sylius\ElasticSearchPlugin\Model\SearchableInterface;

abstract class Updated
{
    /**
     * @var EntityInterface
     */
    private $entity;

    /**
     * @param EntityInterface $entity
     */
    public function __construct(SearchableInterface $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param SearchableInterface $entity
     *
     * @return self
     */
    abstract public static function occur(SearchableInterface $entity);

    /**
     * @return SearchableInterface
     */
    public function entity(): SearchableInterface
    {
        return $this->entity;
    }
}
