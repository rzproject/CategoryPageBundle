<?php
namespace Rz\CategoryPageBundle\Model;

use Sonata\PageBundle\Model\PageInterface;
use Sonata\ClassificationBundle\Model\CategoryInterface;
use Rz\CoreBundle\Model\RelationModelInterface;

interface CategoryHasPageInterface extends RelationModelInterface
{
    /**
     * @return mixed
     */
    public function getPage();

    /**
     * @param mixed $category
     */
    public function setPage(PageInterface $page);

    /**
     * @return mixed
     */
    public function getCategory();

    /**
     * @param mixed $category
     */
    public function setCategory(CategoryInterface $category);
}
