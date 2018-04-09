<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) sr-tag.de Sven Rhinow Webentwicklung
 *
 * @package recurring_element
 * @link    https://www.sr-tag.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['content'], -1, array
(
	'recurring_element' => array
	(
		'tables'      => array('tl_recurring_element', 'tl_recurring_element_items'),
		'icon'        => 'system/modules/calendar/assets/icon.gif',
		'table'       => array('TableWizard', 'importTable'),
		'list'        => array('ListWizard', 'importList')
	)
));


/**
 * Front end modules
 */
array_insert($GLOBALS['FE_MOD'], 2, array
(
	'recurring_element' => array
	(
		'recel_current_item'    => 'Srhinow\recurringElement\ModuleCurrentItem',
	)
));


/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'recurringelements';
$GLOBALS['TL_PERMISSIONS'][] = 'recurringelementp';
