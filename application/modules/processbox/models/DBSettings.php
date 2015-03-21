<?php

/**
 * Class Processbox_Model_DBSettings
 */
class Processbox_Model_DBSettings
{

	/**
	 * @var resource
	 */
	private static $instance;

	/**
	 * Connect to the database when initiated
	 */
	private function __construct()
	{
		self::$instance = mysql_connect(Zend_Registry::getInstance()->constants->host,
			Zend_Registry::getInstance()->constants->username, Zend_Registry::getInstance()->
				constants->password);
		mysql_select_db(Zend_Registry::getInstance()->constants->dbname, self::$instance);

		/**
		 * Post connection scripts to setup the time zones
		 * @see index.php
		 */
		mysql_query("SET time_zone = '+04:00'");
		date_default_timezone_set('Asia/Dubai');
	}

	/**
	 * This method checks to see if the instance already exists, if exists this will be used, else the instance is created
	 *
	 * @return Processbox_Model_DBSettings|resource
	 */
	public static function getInstance()
	{
		if(empty(self::$instance))
		{
			self::$instance = new Processbox_Model_DBSettings();
		}

		return self::$instance;
	}


	/**
	 * @param $table_name
	 * @param string $condition_field
	 * @param string $condition_value
	 * @return array
	 */
	public static function fetch_record($table_name, $condition_field = '', $condition_value = '')
	{
		$arr_result = array();
		if(!empty($condition_field))
		{
			$code = " where $condition_field='$condition_value'";
		}
		$qry = "select * from `{$table_name}` {$code};";

		$rst = mysql_query($qry);
		if($rst && mysql_num_rows($rst) > 0)
		{
			while($row = mysql_fetch_array($rst))
			{
				$arr_result[] = $row;
			}
		}

		return $arr_result;
	}
}