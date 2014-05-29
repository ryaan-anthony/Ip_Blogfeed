<?php

class Ip_Blogfeed_Block_Posts_View extends Mage_Core_Block_Template
{

    function __construct()
    {
        parent::__construct();
        $this->setPost(Mage::registry('blogfeed_post'));
    }

    protected function _prepareLayout()
    {
        if ($meta_title = Mage::registry('blogfeed_post')->getMetaTitle()) {
            $this->getLayout()->getBlock('head')->setTitle($meta_title);
        }
    }

}