<?php


class Ip_Blogfeed_Block_Adminhtml_Posts extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_addButtonLabel = 'Add New Post';

    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_posts';
        $this->_blockGroup = 'blogfeed';
        $this->_headerText = Mage::helper('blogfeed')->__('Blog Posts');
    }

}