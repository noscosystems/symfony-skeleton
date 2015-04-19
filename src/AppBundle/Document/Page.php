<?php

namespace AppBundle\Document;

use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Knp\Menu\NodeInterface as MenuNodeInterface;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Page implements RouteReferrersReadInterface, MenuNodeInterface
{
    use ContentTrait;

    /**
     * @PHPCR\Children()
     */
    protected $children;

    public function getName()
    {
        return $this->title;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getOptions()
    {
        return array(
            'label' => $this->title,
            'content' => $this,

            'attributes'         => [],
            'childrenAttributes' => [],
            'displayChildren'    => true,
            'linkAttributes'     => [],
            'labelAttributes'    => [],
        );
    }
}
