<?php

class Ip_Blogfeed_Block_Posts_List extends Mage_Core_Block_Template
{

    function __construct()
    {
        parent::__construct();
        $this->setPostCollection(Mage::registry('blogfeed_collection'));
    }

    protected function _prepareLayout()
    {
        if ($meta_title = Mage::getStoreConfig('blogfeed/posts/list_meta')) {
            $this->getLayout()->getBlock('head')->setTitle($meta_title);
        }
    }

}