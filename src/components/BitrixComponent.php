<?php

namespace gozoro\components\bitrix;


use gozoro\components\bitrix\CurrentBitrixUser;


/**
 * Component to get data from CMS CMS 1C Bitrix
 *
 * @property CurrentBitrixUser $user bitrix user
 */
class BitrixComponent extends \yii\base\Component
{

	/**
	 * Путь к корню сайта, где лежит папка bitrix.
	 * @var string
	 */
	public $DOCUMENT_ROOT;

	/**
	 * Путь к файлу prolog_before.php отосительно DOCUMENT_ROOT.
	 * Путь должен начинаться с /bitrix/...
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

		define("NO_KEEP_STATISTIC", true);
		define("NOT_CHECK_PERMISSIONS", true);


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
	 * @param string $moduleId
	 * @return \gozoro\components\bitrix\BitrixModule
	 */
	public function getModule($moduleId)
	{
		return new BitrixModule($moduleId);
	}
}