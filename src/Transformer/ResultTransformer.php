<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Transformer;

use Sylius\Component\Product\Model\ProductInterface;
use ONGR\FilterManagerBundle\DependencyInjection\ONGRFilterManagerExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ResultTransformer
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * ResultTransformer constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->requestStack = $requestStack;
    }

    /**
     * @param string $filterId
     * @param string $searchResultList
     * @param string $documentListViewClass
     */
    public function searchAndTransformToOrm(
        $ormClass = ProductInterface::class,
        $filterId = 'product_list',
        $searchResultList = 'sylius_elastic_search.factory.product_list_view',
        $documentListViewClass = 'sylius_elastic_search.view.product_list.class'
    ): array {

        $response = $this->container->get(ONGRFilterManagerExtension::getFilterManagerId($filterId))->handleRequest($this->requestStack->getCurrentRequest());
        $result = $this->container->get($searchResultList)->createFromSearchResponse($response, $this->container->getParameter($documentListViewClass));

        $ids = array_reduce($result->items, function ($acc, $item) {
            return array_merge($acc, [$item->id]);
        }, []);

        /** @var QueryBuilder $qb */
        $qb = $this->container->get('doctrine')->getRepository($ormClass)->createQueryBuilder('t');
        return $qb->where($qb->expr()->in('t.id', $ids))->getQuery()->getResult();
    }


}
