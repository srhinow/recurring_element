<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Calendar
 * @link    https://contao.org
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
		'recel_current_item'    => 'SvenRhinow\recurring_element\ModuleCurrentItem',
	)
));


/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'recurringelements';
$GLOBALS['TL_PERMISSIONS'][] = 'recurringelementp';
