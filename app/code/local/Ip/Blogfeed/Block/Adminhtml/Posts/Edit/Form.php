<?php

class Ip_Blogfeed_Block_Adminhtml_Posts_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $data = Mage::registry('posts_data');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('posts_id' => $this->getRequest()->getParam('posts_id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('post_form', array(
            'legend' =>Mage::helper('blogfeed')->__('Blog Post'),
        ));


        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('blogfeed')->__('Title'),
            'class'     => 'required-entry',
            'style'     =>  'width:700px;',
            'required'  => true,
            'name'      => 'title',
        ));

        $fieldset->addField('url_key', 'text', array(
            'label'     => Mage::helper('blogfeed')->__('Url Key'),
            'style'     =>  'width:700px;',
            'name'      => 'url_key',
        ));

        $fieldset->addField('description', 'editor', array(
            'label'     => Mage::helper('blogfeed')->__('Description'),
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'description',
            'style'     => 'width:700px; height:500px;',
            'wysiwyg'   => true,
        ));

        $fieldset->addField('date', 'hidden', array(
            'label'     => '',
            'name'      => 'date',
        ));

        $data->setDate(time());

        $form->setValues($data);

        return parent::_prepareForm();
    }

}