<?php

namespace gozoro\bitrix;


use gozoro\bitrix\CurrentBitrixUser;


/**
 * Component to get data from CMS 1C Bitrix.
 *
 * Tested with CMS 1C Bitrix 17.5.4.
 *
 * @property CurrentBitrixUser $user bitrix user
 */
class BitrixComponent extends \yii\base\Component
{
	/**
	 * The path to the root of the site where the bitrix folder is located.
	 * @var string
	 */
	public $DOCUMENT_ROOT;

	/**
	 * The path to the file prolog_before.php relative to DOCUMENT_ROOT.
	 * The path must start with /bitrix/...
	 * @var string|array of string
	 */
	public $prolog = "/bitrix/modules/main/include/prolog_before.php";



	public function init()
	{
		if(!$this->DOCUMENT_ROOT)
			throw new \yii\base\Exception('Undefined DOCUMENT_ROOT.');

		if(!$this->prolog)
			throw new \yii\base\Exception('Undefined prolog path.');

		$_SERVER["DOCUMENT_ROOT"] = $this->DOCUMENT_ROOT;

		if(!defined('NO_KEEP_STATISTIC'))
			define('NO_KEEP_STATISTIC', true);

		if(!defined('NOT_CHECK_PERMISSIONS'))
			define('NOT_CHECK_PERMISSIONS', true);

		$error_reporting = error_reporting();
		$display_errors = ini_get('display_errors');

		if(is_array($this->prolog))
		{
			foreach($this->prolog as $prolog)
			{
				require($this->DOCUMENT_ROOT.$prolog);
			}
		}
		else
		{
			require($this->DOCUMENT_ROOT.$this->prolog);
		}

		// disable bitrix exception and error handlers
		restore_exception_handler();
		restore_error_handler();

		// restore display_errors and error_reporting values
		ini_set('display_errors', $display_errors);
		error_reporting($error_reporting);
	}


	/**
	 * Returns an object of the current user of the system Bitrix.
	 * Can be used to retrieve data about the current user and to search for other users.
	 *
	 * @return CurrentBitrixUser
	 */
	public function getUser()
	{
		return new CurrentBitrixUser();
	}


	/**
	 * Returns an object to gets the values of the module options
	 * @param string $moduleId module ID
	 * @param string $siteId site ID
	 * @return \gozoro\components\bitrix\BitrixModule
	 */
	public function getModule($moduleId, $siteId="")
	{
		return new BitrixModule($moduleId, $siteId);
	}
}