<?php

class Processbox_ManageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body

	    $path = Zend_Registry::getInstance()->constants->fullpath;
	    $propertyimagesettings = Zend_Registry::getInstance()->constants->propertyimagesettings;
	    $_SESSION["umode"] = "$path|uploads/".$propertyimagesettings;
	    $this->view->guest_id = 1;
        $manageproperty_obj = new Processbox_Model_ManageProperty($this->view->guest_id);
        $country_arry = $manageproperty_obj->get_country();
	    $this->view->currency_arry = $manageproperty_obj->get_currency();
	    $this->view->units_arry = $manageproperty_obj->get_unit();

	    $this->view->apartment_category   = $manageproperty_obj->get_apartment_category();
	    $this->view->property_id   = $manageproperty_obj->get_property_id();
	    $this->view->basic_details = $manageproperty_obj->get_basic_details();
	    
        $this->view->country_arry = $country_arry;


    }

    public function testAction()
    {

        $this->view->autocomplete = "";
    }




    public function uploadhandlerAction()
    {
        $upload_handler = new Processbox_Model_UploadHandler();
    }

    public function test2Action()
    {


        $path = Zend_Registry::getInstance()->constants->fullpath;
        $_SESSION["umode"] = "$path|uploads/properties|800|520|500|200|150|80|80";

        $this->view->autocomplete = "";
    }

    public function getcityAction()
    {

        $country_code = "ae";
        $cityname = "";
        if(isset($this->getRequest()->countrycode))
        {
            $country_code = $this->getRequest()->countrycode;
        }


        if(isset($this->getRequest()->term))
        {
            $cityname = $this->getRequest()->term;
        }


        $manageproperty_obj = new Processbox_Model_ManageProperty();
        $city_arry =$manageproperty_obj->get_city($country_code,$cityname);

        $city_arry = array_map('utf8_encode', $city_arry);



        $this->view->ciy_json = json_encode($city_arry);
    }






}

