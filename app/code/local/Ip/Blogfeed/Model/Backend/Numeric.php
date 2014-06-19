<?php

class Ip_Blogfeed_Model_Backend_Numeric extends Mage_Core_Model_Config_Data
{

    public function save()
    {
        $this->setValue(intval($this->getValue()));
        return parent::save();
    }

}