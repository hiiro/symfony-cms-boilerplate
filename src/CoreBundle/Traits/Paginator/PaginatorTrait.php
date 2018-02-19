<?php

namespace CoreBundle\Traits\Paginator;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @property ContainerInterface $container
 */
trait PaginatorTrait
{

    /**
     * @param mixed $object
     * @param int   $page
     * @param int   $limit
     * @param array $options
     *
     * @return SlidingPagination
     */
    public function paginate($object, $page, $limit = 10, array $options = [])
    {
        /* @var \Knp\Component\Pager\Paginator $paginator */
        $paginator = $this->container->get('knp_paginator');
        $paginator->setDefaultPaginatorOptions($options);

        return $paginator->paginate($object, $page, $limit);
    }

}