<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
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

class LoadData implements FixtureInterface, ContainerAwareInterface
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
	
	private function loadFunctions()
	{
		$ac_model = $this->container->get('ks.core.ac_model');
		// ACCESS_CONTROL
		$access_control = new AccessControl();
		$access_control
			->setId('ACCESS_CONTROL')
			->setDescription('Administración de Funciones');
		$ac_model->insert($access_control);
		
		// MENUS
		$menus = new AccessControl();
		$menus
			->setId('MENUS')
			->setDescription('Administración de los menus de la aplicación');
		$ac_model->insert($menus);
		
		// REP_ACL
		$rep_acl = new AccessControl();
		$rep_acl
			->setId('REP_ACL')
			->setDescription('Reporte de permisos de acceso');
		$ac_model->insert($rep_acl);
		
		// REP_AUDIT
		$rep_audit = new AccessControl();
		$rep_audit
			->setId('REP_AUDIT')
			->setDescription('Reporte de auditoria');
		$ac_model->insert($rep_audit);
		
		// REP_USERS_ROLES
		$rep_users_roles = new AccessControl();
		$rep_users_roles
			->setId('REP_USERS_ROLES')
			->setDescription('Reporte de usuarios y roles');
		$ac_model->insert($rep_users_roles);
		
		// ROLES
		$roles = new AccessControl();
		$roles
			->setId('ROLES')
			->setDescription('Administración de Roles');
		$ac_model->insert($roles);
		
		// USERS
		$users = new AccessControl();
		$users
			->setId('USERS')
			->setDescription('Administración de Usuarios');
		$this->container->get('ks.core.ac_model')->insert($users);
	}
	
	private function loadMenu()
	{
		$menu_model = $this->container->get('ks.core.menu_model');
		
		// MAIN Menu
		$main = new Menu();
		$main
			->setId('MAIN')
			->setName('Menu principal');
		$menu_model->insert($main);
		
		$root = $this->em->getRepository('KsCoreBundle:MenuItem')->getRootItem($main->getId());
		
		// Seguridad
		$seguridad = new MenuItem();
		$seguridad
			->setMenuId($main->getId())
			->setParentId($root->getId())
			->setLabel('Seguridad')
			->setRoute(null)
			->setItemOrder(1)
			->setIcon('fa fa-lock fa-fw')
			->setIsBranch(true)
			->setVisible(true)
			->setAcId(null)
			->setMask(null)
			;
		$menu_model->insertItem($main, $seguridad);
		
		// Usuarios
		$usuarios = new MenuItem();
		$usuarios
			->setMenuId($main->getId())
			->setParentId($seguridad->getId())
			->setLabel('Usuarios')
			->setRoute('users')
			->setItemOrder(1)
			->setIcon('fa fa-user fa-fw')
			->setIsBranch(false)
			->setVisible(true)
			->setAcId('USERS')
			->setMask(MaskBuilder::MASK_VIEW)
			;
		$menu_model->insertItem($main, $usuarios);
		
		// Roles
		$roles = new MenuItem();
		$roles
			->setMenuId($main->getId())
			->setParentId($seguridad->getId())
			->setLabel('Roles')
			->setRoute('roles')
			->setItemOrder(2)
			->setIcon('fa fa-group fa-fw')
			->setIsBranch(false)
			->setVisible(true)
			->setAcId('ROLES')
			->setMask(MaskBuilder::MASK_VIEW)
			;
		$menu_model->insertItem($main, $roles);
		
		// Reportes
		$reportes = new MenuItem();
		$reportes
			->setMenuId($main->getId())
			->setParentId($seguridad->getId())
			->setLabel('Reportes')
			->setRoute(null)
			->setItemOrder(3)
			->setIcon('fa fa-database fa-fw')
			->setIsBranch(true)
			->setVisible(true)
			->setAcId(null)
			->setMask(null)
			;
		$menu_model->insertItem($main, $reportes);
		
		// Permisos
		$permisos = new MenuItem();
		$permisos
			->setMenuId($main->getId())
			->setParentId($reportes->getId())
			->setLabel('Permisos')
			->setRoute('acls')
			->setItemOrder(1)
			->setIcon('fa fa-key fa-fw')
			->setIsBranch(false)
			->setVisible(true)
			->setAcId('REP_ACL')
			->setMask(MaskBuilder::MASK_VIEW)
			;
		$menu_model->insertItem($main, $permisos);
		
		// Usuarios y Roles
		$user_roles = new MenuItem();
		$user_roles
			->setMenuId($main->getId())
			->setParentId($reportes->getId())
			->setLabel('Usuarios y Roles')
			->setRoute('rep_users_roles')
			->setItemOrder(2)
			->setIcon('fa fa-group fa-fw')
			->setIsBranch(false)
			->setVisible(true)
			->setAcId('REP_USERS_ROLES')
			->setMask(MaskBuilder::MASK_VIEW)
			;
		$menu_model->insertItem($main, $user_roles);
		
		// Reporte de Auditoría
		$rep_audit = new MenuItem();
		$rep_audit
			->setMenuId($main->getId())
			->setParentId($reportes->getId())
			->setLabel('Reporte de Auditoría')
			->setRoute('rep_audit')
			->setItemOrder(3)
			->setIcon('fa fa-eye fa-fw')
			->setIsBranch(false)
			->setVisible(true)
			->setAcId('REP_AUDIT')
			->setMask(MaskBuilder::MASK_VIEW)
			;
		$menu_model->insertItem($main, $rep_audit);
		
		// Configuración
		$config = new MenuItem();
		$config
			->setMenuId($main->getId())
			->setParentId($root->getId())
			->setLabel('Configuración')
			->setRoute(null)
			->setItemOrder(2)
			->setIcon('fa fa-gear fa-fw')
			->setIsBranch(true)
			->setVisible(true)
			->setAcId(null)
			->setMask(null)
			;
		$menu_model->insertItem($main, $config);
		
		// Menus
		$menus = new MenuItem();
		$menus
			->setMenuId($main->getId())
			->setParentId($config->getId())
			->setLabel('Menus')
			->setRoute('menus')
			->setItemOrder(1)
			->setIcon('fa fa-list fa-fw')
			->setIsBranch(false)
			->setVisible(true)
			->setAcId('MENUS')
			->setMask(MaskBuilder::MASK_VIEW)
			;
		$menu_model->insertItem($main, $menus);
		
		// Funciones
		$funciones = new MenuItem();
		$funciones
			->setMenuId($main->getId())
			->setParentId($config->getId())
			->setLabel('Funciones')
			->setRoute('acs')
			->setItemOrder(2)
			->setIcon('fa fa-circle fa-fw')
			->setIsBranch(false)
			->setVisible(true)
			->setAcId('ACCESS_CONTROL')
			->setMask(MaskBuilder::MASK_VIEW)
			;
		$menu_model->insertItem($main, $funciones);
	}
	
	private function loadRoles()
	{
		$role_model = $this->container->get('ks.core.role_model');
		
		$admin = new Role();
		$admin
			->setId('ROLE_ADMIN')
			->setDescription('Administrador');
		$role_model->insert($admin);
		
		// ACLs
		$admin_acl_1 = new AccessControlList();
		$admin_acl_1
			->setRoleId($admin->getId())
			->setAcId('ACCESS_CONTROL')
			->setMaskView(true)
			->setMaskCreate(true)
			->setMaskEdit(true)
			->setMaskDelete(true);
		$role_model->insertAcl($admin, $admin_acl_1);
		
		$admin_acl_2 = new AccessControlList();
		$admin_acl_2
			->setRoleId($admin->getId())
			->setAcId('MENUS')
			->setMaskView(true)
			->setMaskCreate(true)
			->setMaskEdit(true)
			->setMaskDelete(true);
		$role_model->insertAcl($admin, $admin_acl_2);
		
		$admin_acl_3 = new AccessControlList();
		$admin_acl_3
			->setRoleId($admin->getId())
			->setAcId('ROLES')
			->setMaskView(true)
			->setMaskCreate(true)
			->setMaskEdit(true)
			->setMaskDelete(true);
		$role_model->insertAcl($admin, $admin_acl_3);
		
		$admin_acl_4 = new AccessControlList();
		$admin_acl_4
			->setRoleId($admin->getId())
			->setAcId('USERS')
			->setMaskView(true)
			->setMaskCreate(true)
			->setMaskEdit(true)
			->setMaskDelete(true);
		$role_model->insertAcl($admin, $admin_acl_4);
		
		$admin_acl_5 = new AccessControlList();
		$admin_acl_5
			->setRoleId($admin->getId())
			->setAcId('REP_AUDIT')
			->setMaskView(true)
			->setMaskCreate(false)
			->setMaskEdit(false)
			->setMaskDelete(false);
		$role_model->insertAcl($admin, $admin_acl_5);
		
		$admin_acl_6 = new AccessControlList();
		$admin_acl_6
			->setRoleId($admin->getId())
			->setAcId('REP_ACL')
			->setMaskView(true)
			->setMaskCreate(false)
			->setMaskEdit(false)
			->setMaskDelete(false);
		$role_model->insertAcl($admin, $admin_acl_6);
		
		$admin_acl_7 = new AccessControlList();
		$admin_acl_7
			->setRoleId($admin->getId())
			->setAcId('REP_USERS_ROLES')
			->setMaskView(true)
			->setMaskCreate(false)
			->setMaskEdit(false)
			->setMaskDelete(false);
		$role_model->insertAcl($admin, $admin_acl_7);
	}
	
	private function loadUsers()
	{
		$user_model = $this->container->get('ks.core.user_model');
		
		$admin = new User();
		$admin
			->setUsername('admin')
			->setEmail('admin@localhost.com');
		
		if ($this->container->get('ks.core.ac')->localPasswordEnabled())
		{
			$admin
				->setGeneratedPassword('Ch@ng3_m3')
				->setPasswordExpired(true);
		}
		
		$user_model->insert($admin);
		
		$admin_role_1 = new UserRole();
		$admin_role_1
			->setRoleId('ROLE_ADMIN')
			->setUserId($admin->getId());
		$user_model->insertRole($admin_role_1);
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