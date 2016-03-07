<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	/**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		// Page header
		$hdr = array('title' => 'Inicio', 'small' => '');
		
		// Breadcrumb
		$bc = array();
		$bc[] = array('description'=>'Inicio');
		
        return $this->render('KsAdminLteThemeBundle::default.html.twig', array('hdr' => $hdr, 'bc' => $bc));
    }
}
