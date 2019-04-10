<?php

namespace gozoro\bitrix;

use \CUser;

/**
 *
 * Bitrix user
 *
 * @property int $id user ID
 * @property string $login user login
 * @property string $email user email
 * @property string $name user first name
 * @property string $firstName user first name
 * @property string $lastName user last name
 * @property string $fullName user full name
 * @property array $groups user group IDs
 */
class BitrixUser extends \yii\base\BaseObject
{
	private $row;



	/**
	 * Bitrix user
	 * @param array $row
	 */
	public function __construct($row = array())
	{
		if(is_array($row))
		{
			$this->row = $row;
		}
		$this->init();
	}

	/**
	 * Returns user ID
	 * @return int
	 */
	public function getId()
	{
		if(array_key_exists('ID', $this->row))
			return $this->row['ID'];
		else
			return null;
	}

	/**
	 * Returns user login
	 * @return string|null
	 */
	public function getLogin()
	{
		if(array_key_exists('LOGIN', $this->row))
			return $this->row['LOGIN'];
		else
			return null;
	}

	/**
	 * Returns user email
	 * @return string
	 */
	public function getEmail()
	{
		if(array_key_exists('EMAIL', $this->row))
			return $this->row['EMAIL'];
		else
			return null;
	}

	/**
	 * Returns user first name. Alias getFirstName().
	 * @return string
	 */
	public function getName()
	{
		return $this->getFirstName();
	}

	/**
	 * Returns user first name
	 * @return string
	 */
	public function getFirstName()
	{
		if(array_key_exists('NAME', $this->row))
			return $this->row['NAME'];
		else
			return null;
	}

	/**
	 * Returns user last name
	 * @return string
	 */
	public function getLastName()
	{
		if(array_key_exists('LAST_NAME', $this->row))
			return $this->row['LAST_NAME'];
		else
			return null;
	}

	/**
	 * Returns user full name
	 * @return string
	 */
	public function getFullName()
	{
		return $this->getFirstName().' '.$this->getLastName();
	}

	/**
	 * Returns user other params
	 * @param string $key param name
	 * @return string
	 */
	public function getParam($key)
	{
		if(array_key_exists($key, $this->row))
			return $this->row[$key];
		else
			return null;
	}

	/**
	 * Returns source bitrix user array.
	 *
	 *
	 * Array
	 * (
	 *     [ID] => 2
	 *     [TIMESTAMP_X] => 08.03.2019 12:05:38
	 *     [LOGIN] => demo
	 *     [PASSWORD] => gE6{\Dn1b456a2e973883e36ae33d19eafcace57
	 *     [CHECKWORD] => kQXbAygW006b08d5b4f94a41df14b11e08cc51ea
	 *     [ACTIVE] => Y
	 *     [NAME] => demo
	 *     [LAST_NAME] =>
	 *     [EMAIL] => email@example.com
	 *     [LAST_LOGIN] => 01.02.2018 22:47:10
	 *     [DATE_REGISTER] => 15.07.2016 21:39:58
	 *     [LID] => s1
	 *     [PERSONAL_PROFESSION] =>
	 *     [PERSONAL_WWW] =>
	 *     [PERSONAL_ICQ] =>
	 *     [PERSONAL_GENDER] =>
	 *     [PERSONAL_BIRTHDATE] =>
	 *     [PERSONAL_PHOTO] =>
	 *     [PERSONAL_PHONE] =>
	 *     [PERSONAL_FAX] =>
	 *     [PERSONAL_MOBILE] =>
	 *     [PERSONAL_PAGER] =>
	 *     [PERSONAL_STREET] =>
	 *     [PERSONAL_MAILBOX] =>
	 *     [PERSONAL_CITY] =>
	 *     [PERSONAL_STATE] =>
	 *     [PERSONAL_ZIP] =>
	 *     [PERSONAL_COUNTRY] => 0
	 *     [PERSONAL_NOTES] =>
	 *     [WORK_COMPANY] => My Work
	 *     [WORK_DEPARTMENT] =>
	 *     [WORK_POSITION] =>
	 *     [WORK_WWW] =>
	 *     [WORK_PHONE] =>
	 *     [WORK_FAX] =>
	 *     [WORK_PAGER] =>
	 *     [WORK_STREET] =>
	 *     [WORK_MAILBOX] =>
	 *     [WORK_CITY] =>
	 *     [WORK_STATE] =>
	 *     [WORK_ZIP] =>
	 *     [WORK_COUNTRY] => 0
	 *     [WORK_PROFILE] =>
	 *     [WORK_LOGO] =>
	 *     [WORK_NOTES] =>
	 *     [ADMIN_NOTES] =>
	 *     [STORED_HASH] =>
	 *     [XML_ID] =>
	 *     [PERSONAL_BIRTHDAY] =>
	 *     [EXTERNAL_AUTH_ID] =>
	 *     [CHECKWORD_TIME] => 2019-03-08 12:05:38
	 *     [SECOND_NAME] =>
	 *     [CONFIRM_CODE] =>
	 *     [LOGIN_ATTEMPTS] => 0
	 *     [LAST_ACTIVITY_DATE] =>
	 *     [AUTO_TIME_ZONE] =>
	 *     [TIME_ZONE] =>
	 *     [TIME_ZONE_OFFSET] =>
	 *     [TITLE] =>
	 *     [BX_USER_ID] => 856d86db0a2d24cff0dc593366ed3ee4
	 *     [LANGUAGE_ID] =>
	 *     [IS_ONLINE] => N
	 *     [UF_my_custom_field] => My custom field
	 * )
	 *
	 *
	 * @return array
	 */
	public function toArray()
	{
		return $this->row;
	}

	/**
	 * Returns user group IDs
	 * @return array of int
	 */
	public function getGroups()
	{
		return CUser::GetUserGroup($this->getId());
	}

	/**
	 *
	 * Updates the values of fields
	 *
	 * @param array $newfields new field values
	 * Example:<br />
	 * 	 array(<br />
	 * 		  "NAME"              => "Ivan",<br />
	 * 		  "LAST_NAME"         => "Ivanov",<br />
	 * 		  "EMAIL"             => "ivanov@example.com",<br />
	 * 		  "LOGIN"             => "ivan",<br />
	 * 		  "ACTIVE"            => "Y",<br />
	 * 		  "GROUP_ID"          => array(1,2),<br />
	 * 		  "PASSWORD"          => "123456",<br />
	 * 		  "CONFIRM_PASSWORD"  => "123456",<br />
	 * 		  );
	 *
	 * @return bool
	 * @throws \yii\base\Exception
	 */
	public function update($newfields=array())
	{
		$USER = new CUser;
		$result = $user->Update($this->getId(), $newfields);
		$err = $user->LAST_ERROR;

		if($err)
		{
			throw new \yii\base\Exception($err);
		}


		return (bool)$result;
	}
}

