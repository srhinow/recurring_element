<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Srhinow',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Module
	'Srhinow\recurringElement\ModuleCurrentItem' => 'system/modules/recurring_element/module/ModuleCurrentItem.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'recel_default' => 'system/modules/recurring_element/templates',
));
