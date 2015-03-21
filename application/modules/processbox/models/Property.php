<?php

class Processbox_Model_Property extends Processbox_Model_Baseblock
{


    public function __construct($property_id)
    {
        $this->property_id = $property_id;
    }



    public function get_selected_property()
    {
        $sql = "select pid,title,address,price,position_lat,short_name as country,city_name as city,
                position_long,description,p_type,p_area,unit_type,unit,p_cat.icon

                from property as pty
                inner join city as cty on cty.city_id = pty.city_id
                inner join countries as conty on conty.iso3 = pty.country_code
                INNER JOIN property_category AS p_cat ON p_cat.p_category = pty.p_category
                where pid = '$this->property_id'";


        $return_arry = array();
        $rst_property = mysql_query($sql);
        $return_arry["active"] = false;
        if(mysql_affected_rows()>0)
        {
            $return_arry["active"] = true;
            $row_property = mysql_fetch_assoc($rst_property);
            $return_arry["title"] = $row_property["title"];
            $return_arry["address"] = $row_property["address"];
            $return_arry["price"] = $row_property["price"];
            $return_arry["country"] = $row_property["country"];
            $return_arry["city"] = $row_property["city"];
            $return_arry["pos_lat"] = $row_property["position_lat"];
            $return_arry["pos_long"] = $row_property["position_long"];
            $return_arry["description"] = $row_property["description"];
            $return_arry["currency"] = $_SESSION['active_currency'];
            $return_arry["currency_symbol"] = $_SESSION['active_currency_symbol'];
            $return_arry["p_icon"] = $row_property['icon'];


            $gallery_ary = $this->get_gallery(1,$row_property["pid"]);

            $return_arry["galleryflag"]= false;
            $return_arry["gallery_arry"] = array();
            if(sizeof($gallery_ary)>0)
            {
                $return_arry["galleryflag"]= true;
                $return_arry["gallery_arry"] = $gallery_ary;
            }

            // print_r($this->view->gallery_arry);
            // exit;




            if($row_property["p_type"] == 0)
            {
                $return_arry["p_type"]= "Rent";

            }
            else
            {
                $return_arry["p_type"] = "Sale";
            }

            // Area

            $return_arry["area"] = $row_property["p_area"];

            $sql_unit = "select name from units where utype = '".$row_property["unit_type"]."'   and id = '".$row_property["unit"]."'";
            $rst_unit = mysql_query($sql_unit);
            $row_unit = mysql_fetch_assoc($rst_unit);

            $return_arry["unit"] = $row_unit["name"];
            //echo $view->render('index.phtml');

        }

        return $return_arry;

    }

    public function get_agents()
    {
        $sql = "SELECT property_owner.*,city_name,short_name FROM property_owner
                INNER JOIN property ON property.`owner_id` = `property_owner`.`owner_id`
                INNER JOIN city ON city.`city_id` = property.city_id
                INNER JOIN countries ON countries.`iso3` = property.country_code

                WHERE pid = '$this->property_id' ";

        $resultarry= array("count"=>0,"agent"=>array());
        $rst = mysql_query($sql);
        if(mysql_affected_rows())
        {
            $row = mysql_fetch_assoc($rst);

            $sql  = 'SELECT * FROM gallery WHERE type_id  = '.$row["owner_id"].' AND gtype = 2 ORDER BY sinking_priority ASC LIMIT 0,1 ';
            $rst_gallery = mysql_query($sql);
            $row_gallery = mysql_fetch_assoc($rst_gallery);
            $row["imagepath"] = $row_gallery["link"].$row_gallery["image"];
            $resultarry= array("count"=>1,"agent"=>$row);

            return $resultarry;
        }

        return $resultarry;

    }


    public function get_recent_properties($daysback = 100)
    {
        $sql = "select pid,title,address,price,position_lat,short_name as country,city_name as city,
                position_long,description,p_type,p_area,unit_type,unit

                from property as pty
                inner join city as cty on cty.city_id = pty.city_id
                inner join countries as conty on conty.iso3 = pty.country_code
                where pid = '$this->property_id'";


        $return_arry = array();
        $rst_property = mysql_query($sql);
        $return_arry["active"] = false;
        if(mysql_affected_rows()>0)
        {
            $return_arry["active"] = true;
            $row_property = mysql_fetch_assoc($rst_property);
            $return_arry["title"] = $row_property["title"];
            $return_arry["address"] = $row_property["address"];
            $return_arry["price"] = $row_property["price"];
            $return_arry["country"] = $row_property["country"];
            $return_arry["city"] = $row_property["city"];
            $return_arry["pos_lat"] = $row_property["position_lat"];
            $return_arry["pos_long"] = $row_property["position_long"];
            $return_arry["description"] = $row_property["description"];
            $return_arry["currency"] = $_SESSION['active_currency'];
            $return_arry["currency_symbol"] = $_SESSION['active_currency_symbol'];



            $gallery_ary = $this->get_gallery(1,$row_property["pid"]);

            $return_arry["galleryflag"]= false;
            $return_arry["gallery_arry"] = array();
            if(sizeof($gallery_ary)>0)
            {
                $return_arry["galleryflag"]= true;
                $return_arry["gallery_arry"] = $gallery_ary;
            }

            // print_r($this->view->gallery_arry);
            // exit;




            if($row_property["p_type"] == 0)
            {
                $return_arry["p_type"]= "Rent";

            }
            else
            {
                $return_arry["p_type"] = "Sale";
            }

            // Area

            $return_arry["area"] = $row_property["p_area"];

            $sql_unit = "select name from units where utype = '".$row_property["unit_type"]."'   and id = '".$row_property["unit"]."'";
            $rst_unit = mysql_query($sql_unit);
            $row_unit = mysql_fetch_assoc($rst_unit);

            $return_arry["unit"] = $row_unit["name"];
            //echo $view->render('index.phtml');

        }

        return $return_arry;

    }



    public function get_amenities()
    {


        $sql = "SELECT amenity_id,`amenity_name`,`amenity_desc`,`image_icon_url`,am_count,am2.`description` AS own_desc,
                amenity_type,am_size,`unit_type`,unit
                FROM amenities AS am1
                INNER JOIN `amenity_property` AS am2
                ON am1.`amenity_id` =am2.`am_id`
                WHERE am2.`p_id` = '$this->property_id' AND am_status =1";


        $return_arry = array();
        $rst_am_property = mysql_query($sql);
        $return_arry["active"] = false;
        if(mysql_affected_rows()>0)
        {
            $return_arry["active"] = true;
            $am_cnt =0;
            while($rw_am_property =mysql_fetch_assoc($rst_am_property))
            {
                    $return_arry[$am_cnt]["amenity_id"] = $rw_am_property["amenity_id"];
                    $return_arry[$am_cnt]["amenity_name"] = $rw_am_property["amenity_name"];
                    $return_arry[$am_cnt]["amenity_desc"] = $rw_am_property["amenity_desc"];
                    $return_arry[$am_cnt]["image_icon_url"] = $rw_am_property["image_icon_url"];
                    $return_arry[$am_cnt]["am_count"] = $rw_am_property["am_count"];
                    $return_arry[$am_cnt]["amenity_type"] = $rw_am_property["amenity_type"];
                    $return_arry[$am_cnt]["own_desc"] = $rw_am_property["own_desc"];
                    $return_arry[$am_cnt]["am_size"] = $rw_am_property["am_size"];
                    $return_arry[$am_cnt]["unit_type"] = $rw_am_property["unit_type"];
                    $return_arry[$am_cnt]["unit"] = $rw_am_property["unit"];

                    $am_cnt++;


            }

        }

        return $return_arry;
    }


}

