<?php

class Ip_Blogfeed_Block_Adminhtml_Posts_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {

        //do this before parent constructor to enable delete button
        $this->_objectId = 'posts_id';

        parent::__construct();

        $this->_blockGroup = 'blogfeed';
        $this->_controller = 'adminhtml_posts';
        $this->_mode = 'edit';

        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('blogfeed')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('posts_data') && Mage::registry('posts_data')->getPostsId())
        {
            return Mage::helper('blogfeed')->__('Post: "%s"', $this->htmlEscape(Mage::registry('posts_data')->getTitle()));
        } else {
            $this->_removeButton('save_and_continue');
            return Mage::helper('blogfeed')->__('New Blog Post');
        }
    }

}