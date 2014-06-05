<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Recurring_element
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'SvenRhinow',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Module
	'SvenRhinow\recurring_element\ModuleCurrentItem' => 'system/modules/recurring_element/module/ModuleCurrentItem.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'recel_default' => 'system/modules/recurring_element/templates',
));
