<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Projection;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\ElasticSearchPlugin\Model\SearchableInterface;

final class ProductProjector extends Projector
{
    /**
     * @param ProductInterface $product
     */
    protected function scheduleCreatingNewDocuments(SearchableInterface $product): void
    {
        /** @var ChannelInterface[] $channels */
        $channels = $product->getChannels();
        foreach ($channels as $channel) {
            /** @var LocaleInterface[] $locales */
            $locales = $channel->getLocales();
            foreach ($locales as $locale) {
                $this->elasticsearchManager->persist(
                    $this->documentFactory->create(
                        $product,
                        $locale,
                        $channel
                    )
                );
            }
        }
    }

    /**
     * @param SearchableInterface|\Sylius\Component\Product\Model\ProductInterface $entity
     * @return DocumentIterator
     */
    protected function getCurrentDocuments(SearchableInterface $entity): DocumentIterator
    {
        return $this->documentRepository->findBy(['code' => $entity->getCode()]);
    }


}
