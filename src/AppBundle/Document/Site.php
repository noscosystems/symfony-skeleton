<?php

namespace AppBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document()
 */
class Site
{
    /**
     * @access protected
     * @PHPCR\Id()
     */
    protected $id;

    /**
     * @access protected
     * @PHPCR\ReferenceOne(targetDocument="AppBundle\Document\Page")
     */
    protected $homepage;

    /**
     * @access protected
     * @PHPCR\Children()
     */
    protected $children;

    /**
     * Get Homepage
     *
     * @access public
     * @return \AppBundle\Document\Page
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Get Children
     *
     * @access public
     * @return unknown
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set Homepage
     *
     * @access public
     * @param \AppBundle\Document\Page $homepage
     * @return self
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
        return $this;
    }

    /**
     * Set ID
     *
     * @access public
     * @param integer $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
