<?php

class Ip_Blogfeed_Block_Adminhtml_Posts_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('posts_grid');
        $this->setDefaultSort('posts_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('blogfeed/posts')
            ->getCollection()
            ->addFieldToSelect('*');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('posts_id', array(
            'header'    => Mage::helper('blogfeed')->__('Post ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'posts_id',
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('blogfeed')->__('Post Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
        $this->addColumn('url_key', array(
            'header'    => Mage::helper('blogfeed')->__('Post Url'),
            'align'     =>'left',
            'index'     => 'url_key',
        ));

        $this->addColumn('date', array(
            'header'    => Mage::helper('blogfeed')->__('Post Date'),
            'align'     => 'left',
            'index'     => 'date',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('posts_id' => $row->getPostsId()));
    }
}