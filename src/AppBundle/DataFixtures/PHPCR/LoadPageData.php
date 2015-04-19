<?php

namespace AppBundle\DataFixtures\PHPCR;

use AppBundle\Document\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;

class LoadPageData implements FixtureInterface
{
    public function load(ObjectManager $dm)
    {
        if (!$dm instanceof DocumentManager) {
            $class = get_class($dm);
            throw new \RuntimeException(sprintf(
                'Fixture requires a PHPCR ODM DocumentManager instance, instance of "%s" given.',
                $class
            ));
        }
        $parent = $dm->find(null, '/cms/pages');

        $page = new Page;
        $page->setTitle('Home');
        $page->setParentDocument($parent);
        $page->setContent('Welcome to the homepage of this really basic CMS.');
        $dm->persist($page);

        $dm->flush();
    }
}
