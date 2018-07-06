<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\Event\ResultViewEvent;
use Sylius\ElasticSearchPlugin\View\ViewInterface;
use Sylius\ElasticSearchPlugin\Document\DocumentInterface;
use Sylius\ElasticSearchPlugin\View\ListView;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
     * @var EntityManager
     */
    protected $eventDispatcher;

    /**
     * ListViewFactory constructor.
     * @param Serializer $serializer
     */
    public function __construct(EntityManager $em, Serializer $serializer, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param SearchResponse $response
     * @param string $entityClass
     * @param string $identifierProperty
     * @return ViewInterface
     * @throws \Exception
     */
    public function createFromSearchResponse(SearchResponse $response): ViewInterface
    {

        $result = $response->getResult();
        $filters = $response->getFilters();

        $listView = new ListView();
        $listView->setFilters($this->serializer->toArray($filters, SerializationContext::create()));
        $pager = $filters['paginator']->getSerializableData()['pager'];
        $listView->setPage($pager['current_page']);
        $listView->setTotal($pager['total_items']);
        $listView->setPages($pager['num_pages']);
        $listView->setLimit($pager['limit']);

        $items = new ArrayCollection();
        foreach ($response->getResult() as $i => $result) {
            $raw = $response->getResult()->getRaw();
            $hit = $raw['hits']['hits'][$i];
            $this->eventDispatcher->dispatch(ResultViewEvent::RESULT_VIEW, new ResultViewEvent($hit, $result));
            $items->add($result);
        }
        $listView->setItems($items);

        return $listView;
    }

}
