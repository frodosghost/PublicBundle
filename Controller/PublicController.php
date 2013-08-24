<?php

namespace Manhattan\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicController extends Controller
{
    public function homeAction()
    {
        return $this->render('ManhattanPublicBundle:Public:home.html.twig');
    }
}
