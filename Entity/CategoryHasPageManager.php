<?php

namespace Rz\CategoryPageBundle\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;
use Sonata\DatagridBundle\Pager\Doctrine\Pager;
use Sonata\DatagridBundle\ProxyQuery\Doctrine\ProxyQuery;

class CategoryHasPageManager extends BaseEntityManager
{
    public function categoryParentWalker($category, &$categories=array()) {
        while ($category->getParent()) {
            $categories[] = array('category'=>$category, 'parent'=>$category->getParent());
            return $this->categoryParentWalker($category->getParent(), $categories);
        }
        return $categories;
    }

    public function findOneByCategory($criteria) {

        $query = $this->getRepository()
            ->createQueryBuilder('chp')
            ->select('chp');

        $fields = $this->getEntityManager()->getClassMetadata($this->class)->getFieldNames();

        $parameters = array();

        if (isset($criteria['category'])) {
            $query->andWhere('chp.category = :category');
            $parameters['category'] = $criteria['category'];
        }

        $query->setParameters($parameters)->setMaxResults(1);

        try {
            return $query->getQuery()->useResultCache(true, 3600)->getSingleResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return;
        }
    }

    public function findOneByPage($criteria) {

        $query = $this->getRepository()
            ->createQueryBuilder('chp')
            ->select('chp');

        $fields = $this->getEntityManager()->getClassMetadata($this->class)->getFieldNames();

        $parameters = array();

        if (isset($criteria['page'])) {
            $query->andWhere('chp.page = :page');
            $parameters['page'] = $criteria['page'];
        }

        $query->setParameters($parameters)->setMaxResults(1);

        try {
            return $query->getQuery()->useResultCache(true, 3600)->getSingleResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return;
        }
    }
}
