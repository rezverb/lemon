<?php

class Processbox_Bootstrap extends Zend_Application_Module_Bootstrap
{

    /**
     * Initiate the constants
     */
    protected function _initConstants()
    {
        $this->registry = Zend_Registry::getInstance();
        $this->registry->constants = new Zend_Config($this->getApplication()->getOption('constants'));

    }


    protected function _initDatabase_Connect()
    {

        $con = Processbox_Model_DBSettings::getInstance();

    }


}

