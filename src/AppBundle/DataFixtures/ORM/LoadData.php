<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Ks\CoreBundle\Entity\AccessControl;
use Ks\CoreBundle\Entity\Menu;
use Ks\CoreBundle\Entity\MenuItem;
use Ks\CoreBundle\Entity\Role;
use Ks\CoreBundle\Entity\AccessControlList;
use Ks\CoreBundle\Entity\User;
use Ks\CoreBundle\Entity\UserRole;
use Ks\CoreBundle\Entity\Parameter;

class LoadData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
	/**
     * @var ContainerInterface
     */
    private $container;
	private $em;
	
	public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 2;
    }
	
	private function loadFunctions()
	{
		
	}
	
	private function loadMenu()
	{
		
	}
	
	private function loadRoles()
	{
		
	}
	
	private function loadUsers()
	{
		
	}
	
    public function load(ObjectManager $manager)
    {
		$this->em = $this->container->get('doctrine')->getManager();
		
		$this->em->getConnection()->beginTransaction();
		
		try {
			
			// Functions
			$this->loadFunctions();
			// Menu
			$this->loadMenu();
			// Roles
			$this->loadRoles();
			// Users
			$this->loadUsers();
			
			$this->em->getConnection()->commit();
			
		} catch (Exception $e) {
			$this->em->getConnection()->rollBack();
			throw $e;
		}
    }
}