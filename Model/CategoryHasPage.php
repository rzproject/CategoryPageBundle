<?php

namespace Rz\CategoryPageBundle\Model;

use Sonata\ClassificationBundle\Model\CategoryInterface;
use Sonata\PageBundle\Model\PageInterface;
use Rz\CoreBundle\Model\RelationModel;

abstract class CategoryHasPage extends RelationModel implements CategoryHasPageInterface
{
    protected $page;

    protected $category;

    protected $block;

    public function __construct()
    {
        $this->position = 0;
        $this->enabled  = true;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getPage().' | '.$this->getCategory();
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
    }
}