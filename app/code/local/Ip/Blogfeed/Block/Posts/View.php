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
        parent::_prepareLayout();
        $headBlock = $this->getLayout()->getBlock('head');
        $title = $this->getPost()->getMetaTitle();
        $headBlock->setTitle($title);
        return $this;
    }

}