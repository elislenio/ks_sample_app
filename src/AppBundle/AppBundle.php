<?php
namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Ks\AdminLteThemeBundle\KsAdminLteThemeBundle;

class AppBundle extends KsAdminLteThemeBundle
{
	const APPVERSION = '1.0.0';
	const APPNAME = 'MyApp';
	
	public function getParent()
    {
        return 'KsAdminLteThemeBundle';
    }
}
