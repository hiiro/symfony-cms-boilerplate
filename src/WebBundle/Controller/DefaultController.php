<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="web_index")
     */
    public function indexAction()
    {
        return $this->render('WebBundle:Default:index.html.twig');
    }

    /**
     * @Route("/homepage", name="homepage")
     */
    public function homepageAction()
    {
        throw new NotFoundHttpException();
    }
}
