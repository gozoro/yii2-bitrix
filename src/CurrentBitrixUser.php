<?php

namespace gozoro\bitrix;

use \CUser;


/**
 * Current bitrix user
 *
 */
class CurrentBitrixUser extends BitrixUser
{

	private $_cuser;



	public function init()
	{
		$this->_cuser = new CUser();
	}


	/**
	 * Returns user ID
	 * @return int
	 */
	public function getId()
	{
		if($this->isAuthorized())
			return @$this->_cuser->GetID();
		else
			return 0;
	}

	/**
	 * Returns user login
	 *
	 * @return string|null
	 */
	public function getLogin()
	{
		if($this->isAuthorized())
			return @$this->_cuser->GetLogin();
		else
			return null;
	}

	/**
	 * Returns user email
	 * @return string
	 */
	public function getEmail()
	{
		if($this->isAuthorized())
			return @$this->_cuser->GetEmail();
		else
			return null;
	}

	/**
	 * Returns full user name
	 * @return string|null
	 */
	public function getFullName()
	{
		if($this->isAuthorized())
			return @$this->_cuser->GetFullName();
		else
			return null;
	}

	/**
	 * Returns first user name
	 * @return string
	 */
	public function getFirstName()
	{
		if($this->isAuthorized())
			return @$this->_cuser->GetFirstName();
		else
			return null;
	}

	/**
	 * Returns user last name
	 * @return string
	 */
	public function getLastName()
	{
		if($this->isAuthorized())
			return @$this->_cuser->GetLastName();
		else
			return null;
	}

	/**
	 * Returns user other params
	 * @param string $key
	 */
	public function getParam($key)
	{
		if($this->isAuthorized())
		{
			$user = $this->getBitrixUser();

			if($user)
			{
				return $user->getParam($key);
			}
		}
		return null;
	}

	/**
	 * If the user is authorized, the method returns TRUE.
	 * @return bool
	 */
	public function isAuthorized()
	{
		if(isset($_SESSION["SESS_AUTH"]["AUTHORIZED"]))
			return @$this->_cuser->IsAuthorized();
		else
			return false;
	}

	/**
	 * If the user is admin, the method returns TRUE
	 * @return bool
	 */
	public function isAdmin()
	{
		return @$this->_cuser->IsAdmin();
	}

	/**
	 * If the user is authorized, the method returns an array of user group IDs
	 * @return array|null
	 */
	public function getGroups()
	{
		if($this->isAuthorized())
			return @$this->_cuser->GetUserGroupArray();
		else
			return null;
	}

	/**
	 * Returns user params array
	 * @return array
	 */
	public function toArray()
	{
		if($this->isAuthorized())
		{
			$USER = $this->getBitrixUser();
			return $USER->toArray();
		}
		return null;
	}


	protected function getBitrixUser()
	{
		static $USER;

		if(!isset($USER))
		{
			$userId = $this->getId();
			$USER = $this->findById($userId);
		}

		return $USER;
	}


	/**
	 * Authorize user to CMS 1C Bitrix
	 * @param int $userId
	 * @param bool $remember
	 * @param bool $updateLastLogin
	 * @return bool
	 */
	public function authorize($userId, $remember=false, $updateLastLogin=true)
	{
		$USER = new CUser;
		return @$USER->Authorize($userId, $remember, $updateLastLogin);
	}


	/**
	 * User login to CMS 1C Bitrix
	 * @param string $login
	 * @param string $password
	 * @param bool $remember
	 */
	public function login($login, $password, $remember=false)
	{
		if(!$this->isAuthorized())
		{
			$USER = new CUser;

			if($remember)
				$bxRemember = 'Y';
			else
				$bxRemember = 'N';

			return @$USER->Login($login, $password, $bxRemember);
		}
		else
			return true;
	}


	/**
	 * User logout from CMS 1C Bitrix
	 * @return boolean
	 */
	public function logout()
	{
		if($this->isAuthorized())
		{
			@$this->_cuser->Logout();
		}
		else
			return true;
	}


	/**
	 * Returns user by ID
	 * @param int $userId
	 * @return BitrixUser
	 */
	public function findById($userId)
	{
		$userId = (int)$userId;
		return $this->findUser( array('ID'=>$userId) );
	}

	/**
	 * Returns user by login
	 * @param string $login
	 * @return BitrixUser | NULL
	 */
	public function findByLogin($login)
	{
		return $this->findUser( array('LOGIN'=>$login) );
	}

	/**
	 * Returns first user is similar
	 * @param array $where
	 * @return BitrixUser | NULL
	 */
	public function findUser($where = [])
	{
			$by = 'id';
			$order = 'asc';
			$filter = $where;
			$result = @CUser::GetList($by, $order, $filter, array('SELECT'=>array('*','UF_*')));

			if($row = @$result->Fetch())
			{
				return new BitrixUser($row);
			}
			else
				return null;
	}

	/**
	 * Returns user array
	 * @param array $where
	 * @return array of BitrixUser
	 */
	public function findUsers($where)
	{
		$by = 'id';
		$order = 'asc';
		$filter = $where;

		$result = @CUser::GetList($by, $order, $filter, array('SELECT'=>array('*','UF_*')));

		$users = array();
		while($row = @$result->Fetch())
		{
			$users[ $row['ID'] ] = new BitrixUser($row);
		}

		return $users;
	}
}
