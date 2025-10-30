<?php
class cUser
{
	var $username = "";
	var $userpass = "";
	var $logined = 0;
	var $active = 0;
	var $table;
	var $rights = array();
	
	var $lasttime = ""; 
	var $lastip = "";
	function cUser($table)
	{
		$this->table = $table;
		$this->logined = 0;
		session_start();
		if ($this->getuserinfo())
		{
			$this->logined = 1;
		}
	}
	function login($loginname, $loginpass)
	{
		$thisdb = new DataBase;
		$sql_User = "select * from ".$this->table." where `username`='".$loginname."'";
		$userL = $thisdb->fetch_one_array($sql_User);
		$one_day = 86400;
		if ($userL['usable'] == 0)
		{
			$usable = 0;
		}
		else
		{
			if (($userL['time'] + $userL['available_time'] * $one_day > time()) || ($userL['available_time'] == 0))
			{
				$usable = 1;
			}
			else
			{
				$usable = 0;
				$thisdb->update($this->table,array(
					'usable' => 0,
					), "`username`='$loginname'");
			}
		}
		if ($loginname && $loginpass && !empty($userL) && md5($loginpass) == $userL['password'])
		{
			if ($usable)
			{
				$_SESSION['oa_user'] = $loginname;
				$_SESSION['oa_rights'] = array(
					'Myoa' => $userL['R_Myoa'], //个人设置的权限
					'Config' => $userL['R_Config'], //网站配置的权限
					'User' => $userL['R_User'], //会员管理的权限
					'News' => $userL['R_News'], //信息中心的权限
					'Note' => $userL['R_Note'], //留言预订的权限
					'Contract' => $userL['R_Contract'], //留言预订的权限
					'Ad' => $userL['R_Ad'], //广告管理的权限
					'Friend' => $userL['R_Friend'], //友情链接的权限
					'Stat' => $userL['R_Stat'],  //网站统计的权限
					'Admin' => $userL['R_Admin'],  //帐号管理的权限
				);
				$_SESSION['oa_active'] = $userL['active'];
				$this->active = $userL['active'];
				$this->lasttime = $userL['last_time'];
				$this->lastip = $userL['last_ip'];
				$thisdb-> update($this->table, array('last_time'=>time(), 'last_ip'=>getip()),"`username`='{$loginname}'");
				return 1;
			}
			else
			{
				return -1;
			}
		}
		else
		{
			return 0;
		}
	}
	function logout()
	{
		if(isset($_COOKIE[session_name()]))
		{ 
			session_destroy(); 
			unset($_COOKIE[session_name()]); 
		}
	}
	function getuserinfo()  //从COOKIE或SESSION中获取用户信息
	{
		if (session_is_registered('oa_user') && session_is_registered('oa_rights'))
		{
			$this->username = strtolower($_SESSION['oa_user']);
			$this->rights = $_SESSION['oa_rights'];
			$this->active = $_SESSION['oa_active'];
			return 1;
		}
		else
		{
			return 0;
		}
	}
}

?>