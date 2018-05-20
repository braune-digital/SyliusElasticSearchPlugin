<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use SimpleBus\Message\Bus\MessageBus;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductImageInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTaxonInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Product\Model\ProductAttributeValueInterface;
use Sylius\Component\Product\Model\ProductVariantTranslationInterface;
use Sylius\ElasticSearchPlugin\Event\ProductCreated;
use Sylius\ElasticSearchPlugin\Event\ProductDeleted;
use Sylius\ElasticSearchPlugin\Event\ProductUpdated;

class ProductPublisher
{
    /**
     * @var MessageBus
     */
    private $eventBus;

    /**
     * @var ProductInterface[]
     */
    private $scheduledInsertions = [];

    /**
     * @var ProductInterface[]
     */
    private $scheduledUpdates = [];

    /**
     * @var ProductInterface[]
     */
    private $scheduledDeletions = [];

    /**
     * @param MessageBus $eventBus
     */
    public function __construct(MessageBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @param OnFlushEventArgs $event
     */
    public function onFlush(OnFlushEventArgs $event): void
    {
        $scheduledInsertions = $event->getEntityManager()->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($scheduledInsertions as $entity) {
            if ($entity instanceof ProductInterface && !isset($this->scheduledInsertions[$entity->getCode()])) {
                $this->scheduledInsertions[$entity->getCode()] = $entity;

                continue;
            }
            $entities = $this->getProductFromEntity($entity);
            foreach ($entities as $entity) {
                if ($entity instanceof ProductInterface && !isset($this->scheduledUpdates[$entity->getCode()])) {
                    $this->scheduledUpdates[$entity->getCode()] = $entity;
                }
            }
        }

        $scheduledUpdates = $event->getEntityManager()->getUnitOfWork()->getScheduledEntityUpdates();
        foreach ($scheduledUpdates as $entity) {

            $entities = $this->getProductFromEntity($entity);
            foreach ($entities as $entity) {
                if ($entity instanceof ProductInterface && !isset($this->scheduledUpdates[$entity->getCode()])) {
                    $this->scheduledUpdates[$entity->getCode()] = $entity;
                }
            }
        }

        $scheduledDeletions = $event->getEntityManager()->getUnitOfWork()->getScheduledEntityDeletions();
        foreach ($scheduledDeletions as $entity) {
            if ($entity instanceof ProductInterface && !isset($this->scheduledDeletions[$entity->getCode()])) {
                $this->scheduledDeletions[$entity->getCode()] = $entity;

                continue;
            }

            $entities = $this->getProductFromEntity($entity);
            foreach ($entities as $entity) {
                if ($entity instanceof ProductInterface && !isset($this->scheduledUpdates[$entity->getCode()])) {
                    $this->scheduledUpdates[$entity->getCode()] = $entity;
                }

            }
        }
    }

    /**
     * @param PostFlushEventArgs $event
     */
    public function postFlush(PostFlushEventArgs $event): void
    {
        foreach ($this->scheduledInsertions as $product) {
            $this->eventBus->handle(ProductCreated::occur($product));
        }

        $scheduledUpdates = array_diff_key(
            $this->scheduledUpdates,
            $this->scheduledInsertions,
            $this->scheduledDeletions
        );
        foreach ($scheduledUpdates as $product) {
            $this->eventBus->handle(ProductUpdated::occur($product));
        }

        foreach ($this->scheduledDeletions as $product) {
            $this->eventBus->handle(ProductDeleted::occur($product));
        }

        $this->scheduledInsertions = [];
        $this->scheduledUpdates = [];
        $this->scheduledDeletions = [];
    }

    /**
     * @param object $entity
     *
     * @return ProductInterface|null
     */
    protected function getProductFromEntity($entity): ?Collection
    {
        if ($entity instanceof ProductInterface) {
            return new ArrayCollection([$entity]);
        }

        if ($entity instanceof ProductTranslationInterface) {
            return $this->getProductFromEntity($entity->getTranslatable());
        }

        if ($entity instanceof ProductVariantInterface) {
            return $entity->getProduct();
        }

        if ($entity instanceof ProductVariantTranslationInterface) {
            return $this->getProductFromEntity($entity->getTranslatable());
        }

        if ($entity instanceof ChannelPricingInterface) {
            return $this->getProductFromEntity($entity->getProductVariant());
        }

        if ($entity instanceof ProductTaxonInterface) {
            return $entity->getProduct();
        }

        if ($entity instanceof ProductAttributeValueInterface) {
            return $entity->getProduct();
        }

        if ($entity instanceof ProductImageInterface) {
            return $this->getProductFromEntity($entity->getOwner());
        }

        return new ArrayCollection();
    }
}
