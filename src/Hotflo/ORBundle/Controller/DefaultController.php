<?php

namespace Hotflo\ORBundle\Controller;

use Hotflo\ORBundle\Entity\Specialist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HotfloORBundle:Default:index.html.twig');
    }
}
