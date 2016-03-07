<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// PARA PRUEBAS - no versionar.
class ZController extends Controller
{
    /**
     * @Route("/test", name="testpage")
     */
    public function testAction(Request $request)
    {
		// ManagerRegistry instance with references to all sessions and document manager instances
        $registry = $this->container->get('doctrine_phpcr');
        
		// PHPCR session instance
        $session = $this->container->get('doctrine_phpcr.default_session');
		
		// PHPCR ODM document manager instance
        $documentManager = $this->container->get('doctrine_phpcr.odm.default_document_manager');
		
		/*
		// Arma el menu
		$root = $session->getRootNode();
        
		$node0 = $root->addNode('mainmenu', 'nt:unstructured');
		$node0->setProperty('text', 'Menú principal');
		
		$node1 = $node0->addNode('security', 'nt:unstructured');
		$node1->setProperty('text', 'Seguridad');
		
		$node1->addNode('users', 'nt:unstructured')
			->setProperty('text', 'Usuarios');
			
		$node1->addNode('roles', 'nt:unstructured')
			->setProperty('text', 'Roles');
			
		$node2 = $node1->addNode('reports', 'nt:unstructured');
		$node2->setProperty('text', 'Reportes');
			
		$node2->addNode('rep_permissions', 'nt:unstructured')
			->setProperty('text', 'Permisos');
			
		$node2->addNode('rep_user_roles', 'nt:unstructured')
			->setProperty('text', 'Usuarios y roles');
			
		$node2->addNode('rep_audit', 'nt:unstructured')
			->setProperty('text', 'Pista de Auditoría');
			
		$node3 = $node0->addNode('settings', 'nt:unstructured');
		$node3->setProperty('text', 'Configuración');
			
		$node3->addNode('functions', 'nt:unstructured')
			->setProperty('text', 'Funciones');
		
		// save the session, i.e. persist the data
		$session->save();
		*/
		
		// retrieve the newly created node
		$node = $session->getNode('/menus/mainmenu');
		
		return $this->render('AppBundle::z_test.html.twig', array(
            'node' => $node
        ));
    }
}
