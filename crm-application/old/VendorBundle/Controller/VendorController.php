<?php

namespace Stc\Bundle\VendorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VendorController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StcVendorBundle:Default:index.html.twig', array('name' => $name));
    }
}
