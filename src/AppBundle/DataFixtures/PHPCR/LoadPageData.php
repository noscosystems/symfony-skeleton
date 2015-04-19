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

        $rootPage = new Page;
        $rootPage->setTitle('main');
        $rootPage->setParentDocument($parent);
        $dm->persist($rootPage);

        $page = new Page;
        $page->setTitle('Home');
        $page->setParentDocument($rootPage);
        $page->setContent(<<<HERE
Welcome to the homepage of this really basic CMS.
HERE
        );
        $dm->persist($page);

        $page = new Page;
        $page->setTitle('About');
        $page->setParentDocument($rootPage);
        $page->setContent(<<<HERE
This page explains what it's all about.
HERE
        );
        $dm->persist($page);

        $dm->flush();
    }
}
