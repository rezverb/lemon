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

        $manageproperty_obj = new Processbox_Model_ManageProperty();
        $country_arry =$manageproperty_obj->get_country();
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


        $path = "D:/xampp/htdocs/dup/lemon/discoverurproperty/public";
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

