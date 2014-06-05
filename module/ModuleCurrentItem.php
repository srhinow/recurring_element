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
 * Run in a custom namespace, so the class can be replaced
 */
namespace SvenRhinow\recurring_element;


/**
 * Class ModuleCurrentItem
 *
 * Front end module "current item".
 * @copyright  Sven Rhinow 2014
 * @author     Sven Rhinow <https://sr-tag.de>
 * @package    recurring_element
 */
class ModuleCurrentItem extends \Module
{

	/**
	 * Current date object
	 * @var integer
	 */
	protected $Date;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'recel_default';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['currentitem'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		// Return if there are no recurring_element
		if (!is_integer($this->recel_recurringelement) || (int) $this->recel_recurringelement == 0)
		{
			#return '';

		}

		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;
		
		$time = time();

		$rElObj = $this->Database->prepare("SELECT * FROM `tl_recurring_element_items` WHERE `pid`=? AND (start='' OR start<$time) AND (stop='' OR stop>$time)  AND `published` = 1 ORDER BY `priority` DESC")
								  ->execute($this->recel_recurringelement);

		if($rElObj->numRows > 0)
		{
			$this->Template->element = $this->getCurrElement($rElObj);
		}
		$this->Template->headline = $this->headline;		

	}

	/**
	* return the current image
	* @param object
	* @return array
	*/
	protected function getCurrElement($dbObj)
	{
		$currImgArr = array();

		while($dbObj->next())
		{	
			$repeatEach = unserialize($dbObj->repeatEach);
			$repeatValue = $repeatEach['value'];
			$repeatUnit = $repeatEach['unit'];
			$imgPath = '';

			if($this->checkRecurring($dbObj->startDate, $dbObj->endDate, $repeatValue, $repeatUnit,$recurrences))
			{
				if($dbObj->addImageSettings == 1)
				{

					$objFile = \FilesModel::findByPk($dbObj->singleSRC);
					$imgPath = $objFile->path;
				}

				$currImgArr[$dbObj->priority] = array
				(
					'imgPath' => $imgPath,
					'settings' => ($dbObj->addImageSettings == 1) ? true : false,
					'alt' => $dbObj->alt,
					'size' => unserialize($dbObj->size),
					'margins' => unserialize($dbObj->imagemargin),
					'bigimgurl'	=> $dbObj->imageUrl,
					'fullsize'	=> ($dbObj->fullsize == 1) ? true : false,
					'caption'	=> $dbObj->caption,
					'cssClass'	=> $dbObj->cssClass,
					'addText'	=> ($dbObj->addText == 1) ? true : false,
					'headline'	=> $dbObj->headline,
					'text'	=> $dbObj->text,
				);

				
			}
		}	
		
		// den mit der hoechsten Prioritaet zuerst	
		krsort($currImgArr);

		// gebe das erste Element aller validen Bilder zurueck
		return array_shift($currImgArr);	 	
	}

	/**
	* check the right image
	* @param int
	* @param int
	* @param int
	* @param string
	* @param int
	* @return bool
	*/
	protected function checkRecurring($startTstmp,$endTstmp, $repeatValue, $repeatUnit, $recurrences)
	{

		$currDate = time();
		$startDate = $endDate = '';
		$firstTest = true;
		$lastDayOfYear = mktime(23, 59, 59, 12, 31, date('Y'));
		$loops = 0;
		do {
			// Wiederholungsangabe beachten
			$loops++;
			if($recurrences > 0 && $recurrences < $loops) continue;

			// set Test-dates
			if($firstTest)
			{
				$startDate = $startTstmp;
				$endDate = $endTstmp;
				$firstTest = false;
			}
			else
			{ 
				$startDate = strtotime('+'.$repeatValue.' '.$repeatUnit, $startDate);
				$endDate = strtotime('+'.$repeatValue.' '.$repeatUnit, $endDate);
			}

			if($currDate >= $startDate && $currDate <= $endDate) return true;

		} while ($startDate <= $lastDayOfYear);

		return false;
	}
}
