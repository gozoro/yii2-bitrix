<?php

namespace gozoro\bitrix;


use \Bitrix\Main\Config\Option;

/**
 * Bitrix module
 */
class BitrixModule extends \yii\base\BaseObject
{
	private $moduleId;
	private $siteId;

	/**
	 * Bitrix module
	 *
	 * @param string $moduleId module ID
	 * @param string $siteId site ID
	 */
	public function __construct($moduleId, $siteId="")
	{
		$this->moduleId = (string)$moduleId;
		$this->siteId   = (string)$siteId;
	}


	/**
	 * Sets module option value
	 * @param string $key
	 * @param string|int $value
	 * @return bool
	 */
	public function setOption($key, $value)
	{
		return Option::set( $this->moduleId, $key, $value, $this->siteId );
	}

	/**
	 * Returns module option value
	 * @param string $key
	 * @param string|int $defaultValue
	 * @return string|int
	 */
	public function getOption($key, $defaultValue="")
	{
		if($this->siteId === "")
			$siteId = false;
		else
			$siteId = $this->siteId;

		return Option::get($this->moduleId, $key, $defaultValue, $siteId);
	}
}