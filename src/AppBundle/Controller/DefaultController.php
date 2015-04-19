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
     * Action: Homepage
     *
     * @access public
     * @Route("/")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $site = $dm->find('AppBundle\Document\Site', '/cms');
        $homepage = $site->getHomepage();
        if (!$homepage) {
            throw $this->createNotFoundException('No homepage configured');
        }
        return $this->forward('AppBundle:Default:page', array(
            'contentDocument' => $homepage
        ));
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

    /**
     * @Route(
     *   name="make_homepage",
     *   pattern="/_cms/make_homepage/{id}",
     *   requirements={"id": ".+"}
     * )
     */
    public function makeHomepageAction($id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $site = $dm->find(null, '/cms');
        if(!$site) {
            throw $this->createNotFoundException('Could not find basic CMS object!');
        }
        $page = $dm->find(null, $id);
        $site->setHomepage($page);
        $dm->persist($site);
        $dm->flush();

        return $this->redirect($this->generateUrl('admin_app_page_edit', [
            'id' => $page->getId(),
        ]));
    }
}
