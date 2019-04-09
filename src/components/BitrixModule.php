<?php

namespace gozoro\components\bitrix;


use \COption;

/**
 * Bitrix module
 */
class BitrixModule extends \yii\base\BaseObject
{
	private $moduleId;

	public function __construct($moduleId)
	{
		$this->moduleId = (string)$moduleId;
	}


	/**
	 * Sets module option value
	 * @param string $key
	 * @param string|int $value
	 * @return bool
	 */
	public function setOption($key, $value)
	{
		return COption::SetOptionString( $this->moduleId, $key, $value );
	}

	/**
	 * Returns module option value
	 * @param string $key
	 * @param string|int $defaultValue
	 * @return string|int
	 */
	public function getOption($key, $defaultValue="")
	{
		$value = COption::GetOptionString($this->moduleId, $key, $defaultValue);
	}
}