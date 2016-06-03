<?php

namespace Rz\CategoryPageBundle\Entity;

use Rz\CategoryPageBundle\Model\CategoryHasPage;

abstract class BaseCategoryHasPage extends CategoryHasPage
{
    /**
     * Pre Persist method
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Pre Update method
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
