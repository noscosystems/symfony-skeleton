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
}
