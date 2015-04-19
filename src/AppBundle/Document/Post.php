<?php

namespace AppBundle\Document;

use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Post implements RouteReferrersReadInterface
{
    use ContentTrait;

    /**
     * @access protected
     * @PHPCR\Date()
     * @var \DateTime
     */
    protected $date;

    /**
     * Update Date
     *
     * @access public
     * @PHPCR\PrePersist()
     * @return void
     */
    public function updateDate()
    {
        if(!$this->date) {
            $this->date = new \DateTime;
        }
    }

    /**
     * Get Date
     *
     * @access public
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set Date
     *
     * @access public
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
}
