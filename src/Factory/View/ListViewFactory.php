<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\View\ViewInterface;
use Sylius\ElasticSearchPlugin\Document\DocumentInterface;
use Sylius\ElasticSearchPlugin\View\ListView;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class ListViewFactory implements ListViewFactoryInterface {

    /**
     * @var PropertyAccessor
     */
    protected $pa;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ListViewFactory constructor.
     * @param Serializer $serializer
     */
    public function __construct(EntityManager $em, Serializer $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->pa = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param SearchResponse $response
     * @param string $entityClass
     * @param string $identifierProperty
     * @param string|null $path
     * @return ViewInterface
     * @throws \Exception
     */
    public function createFromSearchResponse(SearchResponse $response, string $entityClass, string $identifierProperty, string $path = null): ViewInterface
    {
        $repository = $this->em->getRepository($entityClass);

        $result = $response->getResult();
        $filters = $response->getFilters();

        $listView = new ListView();

        $listView->setFilters($this->serializer->toArray($filters, SerializationContext::create()));

        $pager = $filters['paginator']->getSerializableData()['pager'];
        $listView->setPage($pager['current_page']);
        $listView->setTotal($pager['total_items']);
        $listView->setPages($pager['num_pages']);
        $listView->setLimit($pager['limit']);

        /** @var DocumentIterator $result */
        foreach ($response->getResult() as $result) {
            $document = $result;
            if ($path && $path !== '') {
                $document = $this->pa->getValue($result, $path);
            }
            if (!$this->pa->isReadable($document, $identifierProperty)) {
                throw new \Exception("The identifier property of the document could not be read.");
            }
            $entity = $repository->find($this->pa->getValue($document, $identifierProperty));
            if ($entity) {
                $listView->addItem($entity);
            }
        }

        return $listView;
    }

}
