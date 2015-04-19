<?php

namespace AppBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

trait ContentTrait
{
    /**
     * @access protected
     * @PHPCR\Id()
     * @var integer
     */
    protected $id;

    /**
     * @access protected
     * @PHPCR\ParentDocument()
     * @var unknown
     */
    protected $parent;

    /**
     * @access protected
     * @PHPCR\Nodename()
     * @var string
     */
    protected $title;

    /**
     * @access protected
     * @PHPCR\String(nullable=true)
     * @var string
     */
    protected $content;

    /**
     * @access protected
     * @PHPCR\Referrers(
     *     referringDocument="Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route",
     *     referencedBy="content"
     * )
     */
    protected $routes;

    /**
     * Get Content ID
     *
     * @access public
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getParentDocument()
    {
        return $this->parent;
    }

    public function setParentDocument($parent)
    {
        $this->parent = $parent;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
