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
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['recel_current_item']    = '{title_legend},name,headline,type;{config_legend},recel_recurringelement;{template_legend:hide},recel_template;{expert_legend:hide},cssID,space';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['recel_recurringelement'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['recel_recurringelement'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options_callback'        => array('tl_module_recurringelement', 'getRecurringElements'),
	'eval'                    => array('mandatory'=>true, 'multiple'=>false),
	'sql'                     => "varchar(32) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_module']['fields']['recel_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['recel_template'],
	'default'                 => 'seasonimages_default',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_recurringelement', 'getTemplates'),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(32) NOT NULL default ''"
);



/**
 * Class tl_module_recurringelement
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Sven Rhinow 2014
 * @author     Sven Rhinow (kservice@sr-tag.de)
 * @package    recurring_element
 */
class tl_module_recurringelement extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Get all recurring-elements and return them as array
	 * @return array
	 */
	public function getRecurringElements()
	{
		if (!$this->User->isAdmin && !is_array($this->User->recurringelements))
		{
			return array();
		}

		$arr= array();
		$obj = $this->Database->execute("SELECT id, title FROM tl_recurring_element ORDER BY title");

		while ($obj->next())
		{
			if ($this->User->hasAccess($obj->id, 'recurringelementp'))
			{
				$arr[$obj->id] = $obj->title;
			}
		}

		return $arr;
	}



	/**
	 * Return all event templates as array
	 * @return array
	 */
	public function getTemplates()
	{
		return $this->getTemplateGroup('recel_');
	}

}
