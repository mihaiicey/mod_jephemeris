<?php
/**
 * $Id: mod_jephemeris.php 3 2013-08-05 11:53:07Z Szablac $
 * @Project		Ephemeris for Joomla Module
 * @author 		Laszlo Szabo
 * @package		Ephemeris
 * @copyright	Copyright (C) 2010 Saxum 2003 Bt. All rights reserved.
 * @license 	http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL version 3
*/
defined('_JEXEC') or die('Restricted access');
require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');

$ephemeris=ModJephemerisHelper::getLayout($params);
$check['l']=ModJephemerisHelper::render();
require(JModuleHelper::getLayoutPath('mod_jephemeris'));
?>