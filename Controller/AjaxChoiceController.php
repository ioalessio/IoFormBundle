<?php

namespace Io\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AjaxChoiceController extends Controller
{
    /**
     * @Route("/ajax_choice/{param}", name="ioformbundle_ajax_choice", requirements={"_format" = "json"}, defaults={"_format" = "json"})
     */
    public function indexAction($param)
    {
        return array('name' => $name);
    }
}
