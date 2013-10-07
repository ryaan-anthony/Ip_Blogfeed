<?php

class Ip_Blogfeed_Block_Posts_Single extends Mage_Core_Block_Template
{

    function __construct()
    {
        $this->setPost(Mage::registry('blogfeed_post'));
        parent::__construct();
    }

}