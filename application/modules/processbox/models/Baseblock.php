<?php

class Processbox_Model_Baseblock
{


    public function __construct()
    {

    }




    /**
     * @param string $countrystring
     * @return mixed
     */
    public function get_country($countrystring = "in,ae")
    {


        $countryarry = explode(",",$countrystring);



        $countrystring = "";
        foreach($countryarry as $selcountry)
        {
            if($countrystring != "")
            {
                $countrystring .= ",'".$selcountry."'";
            }
            else
            {
                $countrystring .= "'".$selcountry."'";
            }

        }


        $sql = "SELECT * FROM `countries` WHERE iso2 in ({$countrystring})";


        $rst = mysql_query($sql);
        $return = array();
        while($row = mysql_fetch_assoc($rst))
        {
                $return[$row["iso2"]] = $row;
        }


        return $return;

    }




    public function get_city($countrycode = "ae",$city = "")
    {
        $sql2 = "";
        if($city != "")
        {
            $sql2 = "  and city like '{$city}%'  ";
        }
        $sql = "select city_id,city from cities where   country_code = '{$countrycode}' ".$sql2."  limit 0,10  ";



        $rst = mysql_query($sql);

        while($row = mysql_fetch_assoc($rst))
        {
            //$return[] =array("label"=>$row["city"],"value"=>$row["city_id"]);
            $return[] = $row["city"];
        }



        return $return;

    }



    /**
     * @param $galary_type
     * @param $iteam_id
     * @return array
     */
    public function get_gallery($galary_type,$iteam_id)
    {

        $sql =  "select * from gallery where gtype ='".$galary_type."' and type_id =  '".$iteam_id."' order by sinking_priority asc ";

        $rst = mysql_query($sql);
        $gallery_details_arry = array();
        while($row = mysql_fetch_assoc($rst) )
        {
            $gallery_details_arry[] = array("caption"=>$row["caption"],"description"=>$row["description"],
                                           "path"=>$row["link"],"image"=>$row["image"],"priority"=>$row["sinking_priority"]);
        }

        return $gallery_details_arry;

    }


}

