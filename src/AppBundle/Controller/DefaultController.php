<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Page;
use AppBundle\Document\Post;

class DefaultController extends Controller
{
    /**
     * @Route("/app/example", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * Action: Basic CMF Page
     *
     * @access public
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Document\Page $contentDocument
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pageAction(Request $request, Page $contentDocument)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $posts = $dm->getRepository('AppBundle:Post')->findAll();
        return $this->render('AppBundle:Default:page.html.twig', [
            'page' => $contentDocument,
            'posts' => $posts,
        ]);
    }

    /**
     * Action: Basic CMS Post
     *
     * @access public
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Document\Post $contentDocument
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request, Post $contentDocument)
    {
        return $this->render('AppBundle:Default:post.html.twig', [
            'post' => $contentDocument,
        ]);
    }
}
