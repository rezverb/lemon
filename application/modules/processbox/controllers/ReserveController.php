<?php

class Processbox_ReserveController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
      $property_id =  3;

       // Get Property details
        $property_obj = new Processbox_Model_Property($property_id);
        $property_details = $property_obj->get_selected_property();
        $property_amenities = $property_obj->get_amenities();
        $property_agent = $property_obj->get_agents();

      //  echo  $this->view->
        $this->view->dirpath =Zend_Registry::getInstance()->constants->dirpath;





        $this->view->amenities = $property_amenities;
        $this->view->agent = $property_agent;

        if($property_details["active"] == true)
        {

            $this->view->title = $property_details["title"];
            $this->view->address = $property_details["address"];
            $this->view->price = $property_details["price"];
            $this->view->country = $property_details["country"];
            $this->view->city = $property_details["city"];
            $this->view->description = $property_details["description"];
            $this->view->currency = $property_details['currency'];
            $this->view->currency_symbol = $property_details['currency_symbol'];
            $this->view->p_property_icon = $property_details['p_icon'];
            $this->view->p_property_pic = $property_details["gallery_arry"][0]["image"];
            $this->view->p_latitude = $property_details["pos_lat"];
            $this->view->p_longitude = $property_details["pos_long"];
            $this->view->p_longitude = $property_details["pos_long"];




            $this->view->galleryflag= $property_details["galleryflag"];
            $this->view->gallery_arry = $property_details["gallery_arry"];
            $this->view->galleryflag= $property_details["galleryflag"];
            $this->view->p_type= $property_details["p_type"];
            // Area
            $this->view->area = $property_details["area"];
            $this->view->unit = $property_details["unit"];

        }


//        FieldTypeComment
//pidint(11) NOT NULL
//created_datedatetime NULLcreated date
//modified_datedatetime NULLmodified date
//owner_idint(11) NULLowner or agent creating the property
//titlevarchar(255) NULLproperty title
//descriptiontext NULLproperty desc
//country_codevarchar(5) NULLcountry code
//zone_idint(11) NULLzone / state id
//city_idint(11) NULLcity_id
//addresstext NULLaddress of the property
//position_latvarchar(11) NULLlatitude
//position_longvarchar(11) NULLlongitude
//activetinyint(1) NULLstatus
//confirmedtinyint(1) NULLcomplete status
//expiry_datedatetime NULLexpiry date
//currencyvarchar(5) NULLcurrency code
//paymentmode_idint(11) NULLpayment mode id
//property_type_idint(11) NULLproperty type
//postal_codevarchar(11) NULLpostal code
//checkin_datedatetime NULLcheckin_date
//checkout_datedatetime NULLcheckout_date
//checkin_timetime NULLcheckin_time
//p_typetinyint(1) NULL0->Rent,1->Sale
//pricedouble(12,2) NULLproperty price for sale,rent price
//                                         minnightsint(5) NULL0-> contract rent
//areadouble(12,3) NULLtotal area of the place
//unit_typeint(11) NULL2 -> Area unit
//unitint(11) NOT NULLunit type





      //  $helper = new Processbox_Model_Helper();
    }


}

