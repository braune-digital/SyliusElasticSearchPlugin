<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ONGR\ElasticsearchBundle\Annotation as ElasticSearch;
use ONGR\ElasticsearchBundle\Result\ObjectIterator;
use Sylius\ElasticSearchPlugin\Model\VariantDocumentTrait;

/**
 * @ElasticSearch\Nested
 */
class VariantDocument implements DocumentInterface
{
    use VariantDocumentTrait;
}
