<?php

class Processbox_Model_User extends Processbox_Model_Baseblock
{


	public function __construct()
	{

	}




	public function get_user_id($userid)
	{
		$sql = "select * from guest where guest_id = '$userid'";

		$rst = mysql_query($sql);
		$rw = mysql_fetch_assoc($rst);

		return $rw["guest_id"];

	}






}

