<?php

class Processbox_Model_ManageProperty extends Processbox_Model_Baseblock
{

//	Basic Info
	private $property_id;
	private $title;
	private $ptype;
	private $pcategory;
	private $pcurrency;
	private $price;
	private $area;
	private $unit;
	private $desc;
	private $fromdate;
	private $todate;
	private $expiredate;
	private $minnight;
	private $accommodate;
	private $property_status;
	private $admin_approval;


    public function __construct($userid)
    {
	    $sql = "SELECT * FROM property
		WHERE completion_status = 0 AND owner_id = '$userid'
		ORDER BY pid desc";



	    $rst = mysql_query($sql);
	    if(mysql_affected_rows() > 0)
	    {
		    $rw = mysql_fetch_assoc($rst);
		    $this->property_id = $rw["pid"];
		    $this->title = $rw["title"];
		    $this->desc = $rw["description"];
		    $this->accommodate = $rw["pax"];
		    $this->admin_approval = $rw["confirmed"];
		    $this->area = $rw["p_area"];
		    $this->expiredate = $rw["expiry_date"];
		    $this->fromdate = $rw["checkin_date"];
		    $this->todate = $rw["checkout_date"];
		    $this->unit = $rw["unit"];
		    $this->minnight = $rw["minnights"];
		    $this->property_status = $rw["active"];
		    $this->ptype = $rw["p_type"];
		    $this->price = $rw["price"];
		    $this->pcategory = $rw["p_category"];
		    $this->pcurrency = $rw["currency"];


	    }
		else
		{
			$sql = "INSERT INTO property (owner_id,unit) VALUE (1,1) ";
			mysql_query($sql);
			$this->property_id = mysql_insert_id();
			$this->unit = 1;
		}




    }



	public function get_unit($mode = 2)
	{
		$sql = "select * from units where utype = '$mode'";
		$rst = mysql_query($sql);
		while($rw = mysql_fetch_assoc($rst))
		{
			$rnt[$rw["id"]] = array("name"=>$rw["name"]);
		}


		return $rnt;
	}

	public function get_currency()
	{
		$sql = "select * from currency";
		$rst = mysql_query($sql);
		while($rw = mysql_fetch_assoc($rst))
		{
			$rnt[$rw["cur_code"]] = array("name"=>$rw["currency_name"],"symbol"=>$rw["currency_symbol"]);
		}


		return $rnt;
	}

	public function get_apartment_category()
	{
		$sql = "select * from property_category ";
		$rst = mysql_query($sql);
		$rnt = array();
		while($rw = mysql_fetch_row($rst))
		{
			$rnt[$rw[0]] = array("name"=>$rw[1],"image"=>$rw[2]);
		}


		return $rnt;

	}


	public function get_basic_details()
	{
		return array("property_id"=>$this->property_id,
			  "title"=>$this->title,
			  "desc"=>$this->desc,
			  "accommodate"=>$this->accommodate,
			  "admin_approval" => $this->admin_approval,
			  "area" => $this->area,
			  "expiredate" => $this->expiredate,
		      "fromdate"=> $this->fromdate,
			  "todate"=>$this->todate,
			  "unit"=> $this->unit,
			  "minnight"=> $this->minnight,
			  "property_status" => $this->property_status,
			  "ptype" => $this->ptype,
			  "price" => $this->price,
			  "pcategory" => $this-> pcategory,
			  "pcurrency" => $this->pcurrency );
	}


	public function get_property_id()
	{
		return $this->property_id;
	}







}

