<?php

namespace AppBundle\Initializer;

use Doctrine\Bundle\PHPCRBundle\Initializer\InitializerInterface;
use PHPCR\Util\NodeHelper;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use AppBundle\Document\Site;

class SiteInitializer implements InitializerInterface
{
    /**
     * @access private
     * @var string
     */
    private $basePath;

    /**
     * Constructor
     *
     * @access public
     * @param string $basePath
     * @return void
     */
    public function __construct($basePath = '/cms')
    {
        $this->basePath = $basePath;
    }

    /**
     * Initializer
     *
     * @access public
     * @param \Doctrine\Bundle\PHPCRBundle\ManagerRegistry $registry
     * @return void
     */
    public function init(ManagerRegistry $registry)
    {
        $dm = $registry->getManager();
        if ($dm->find(null, $this->basePath)) {
            return;
        }

        $site = new Site;
        $site->setId($this->basePath);
        $dm->persist($site);
        $dm->flush();

        $session = $registry->getConnection();

        // create the 'cms', 'pages', and 'posts' nodes
        NodeHelper::createPath($session, $this->basePath . '/pages');
        NodeHelper::createPath($session, $this->basePath . '/posts');
        NodeHelper::createPath($session, $this->basePath . '/routes');

        $session->save();
    }

    /**
     * Get Initializer Name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'My site initializer';
    }
}
