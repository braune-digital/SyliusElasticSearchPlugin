<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Projection;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\ElasticsearchBundle\Service\Manager;
use ONGR\ElasticsearchBundle\Service\Repository;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\ElasticSearchPlugin\Document\Document;
use Sylius\ElasticSearchPlugin\Event\Created;
use Sylius\ElasticSearchPlugin\Event\Deleted;
use Sylius\ElasticSearchPlugin\Event\Updated;
use Sylius\ElasticSearchPlugin\Factory\Document\DocumentFactoryInterface;
use Sylius\ElasticSearchPlugin\Model\SearchableInterface;

abstract class Projector
{
    /**
     * @var Manager
     */
    protected $elasticsearchManager;

    /**
     * @var Repository
     */
    protected $documentRepository;

    /**
     * @var DocumentFactoryInterface
     */
    protected $documentFactory;

    /**
     * @param Manager $elasticsearchManager
     * @param DocumentFactoryInterface $documentFactory
     */
    public function __construct(
        Manager $elasticsearchManager,
        DocumentFactoryInterface $documentFactory,
        string $documentClass
    ) {
        $this->elasticsearchManager = $elasticsearchManager;
        $this->documentRepository = $elasticsearchManager->getRepository($documentClass);
        $this->documentFactory = $documentFactory;
    }

    /**
     * @param Created $event
     */
    public function handleCreated(Created $event): void
    {
        $this->scheduleCreatingNewDocuments($event->entity());
        $this->scheduleRemovingOldDocuments($event->entity());

        $this->elasticsearchManager->commit();
    }

    /**
     * We create a new entity documents with updated data and remove old once
     *
     * @param Updated $event
     */
    public function handleUpdated(Updated $event): void
    {
        $entity = $event->entity();

        $this->scheduleCreatingNewDocuments($entity);
        $this->scheduleRemovingOldDocuments($entity);

        $this->elasticsearchManager->commit();
    }

    /**
     * We remove deleted entity
     *
     * @param Deleted $event
     */
    public function handleDeleted(Deleted $event): void
    {
        $entity = $event->entity();

        $this->scheduleRemovingOldDocuments($entity);

        $this->elasticsearchManager->commit();
    }

    private function scheduleRemovingOldDocuments(SearchableInterface $entity): void
    {
        $currentDocuments = $this->getCurrentDocuments($entity);

        foreach ($currentDocuments as $sameCodeDocument) {
            $this->elasticsearchManager->remove($sameCodeDocument);
        }
    }

    abstract protected function scheduleCreatingNewDocuments(SearchableInterface $entity): void;
    abstract protected function getCurrentDocuments(SearchableInterface $entity): DocumentIterator;
}
