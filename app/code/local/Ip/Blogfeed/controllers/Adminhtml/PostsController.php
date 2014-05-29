<?php

class Ip_Blogfeed_Adminhtml_PostsController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $model = Mage::getModel('blogfeed/posts');
        if($id = $this->getRequest()->getParam('posts_id', null)){
            $model->load((int) $id);
        }
        Mage::register('posts_data', $model);
        $this->loadLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    public function saveAction()
    {
        $_session = Mage::getSingleton('adminhtml/session');
        if ($data = $this->getRequest()->getPost()){
            /** @var $model Ip_Blogfeed_Model_Posts */
            $model = Mage::getSingleton('blogfeed/posts');
            /* set all post data */
            $model->setData($data);
            /* set the id instead of loading for simplicity */
            if($entity_id = $this->getRequest()->getParam('posts_id', null)){
                $model->setPostsId($entity_id);
            }
            $_session->setFormData($data);
            try {
                if(!$model->getUrlKey()){
                    $url_key = Mage::helper('blogfeed')->makeUrlKey($model->getTitle());
                    $model->setUrlKey($url_key);
                }
                $model->save();
                $model->setRequestPath();
                $_session->setFormData(false);
                $_session->addSuccess(Mage::helper('blogfeed')->__('Blog was successfully saved.'));
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('posts_id' => $model->getPostsId()));
                } else {
                    $this->_redirect('*/*/');
                }
                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this blog post.'));
            }
            $this->_redirectReferer();
        } else {
            $_session->addError(Mage::helper('blogfeed')->__('No blog post found.'));
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('posts_id') > 0 ) {
            try {
                $model = Mage::getSingleton('blogfeed/posts');

                $model->setPostsId($this->getRequest()->getParam('posts_id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('blogfeed')->__('Blog post was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('posts_id' => $this->getRequest()->getParam('posts_id')));
            }
        }
        $this->_redirect('*/*/');
    }

}