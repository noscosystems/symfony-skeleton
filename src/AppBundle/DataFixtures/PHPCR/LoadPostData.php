<?php

namespace AppBundle\DataFixtures\PHPCR;

use AppBundle\Document\Post;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;

class LoadPostData implements FixtureInterface
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
        $parent = $dm->find(null, '/cms/posts');
        foreach (['First', 'Second', 'Third', 'Forth'] as $title) {
            $post = new Post();
            $post->setTitle(sprintf('My %s Post', $title));
            $post->setParentDocument($parent);
            $post->setContent(<<<HERE
This is the content of my post.
HERE
            );
            $dm->persist($post);
        }
        $dm->flush();
    }
}
