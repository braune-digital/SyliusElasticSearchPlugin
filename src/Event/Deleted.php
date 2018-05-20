<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Event;

use Sylius\ElasticSearchPlugin\Model\SearchableInterface;

abstract class Deleted
{
    /**
     * @var SearchableInterface
     */
    private $entity;

    /**
     * @param SearchableInterface $entity
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
