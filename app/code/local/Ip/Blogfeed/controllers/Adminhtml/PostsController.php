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
                $image_id = 'featured_image';
                if(isset($_FILES[$image_id]['name']) && $_FILES[$image_id]['name']) {
                    $uploader = new Varien_File_Uploader($image_id);
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $path = $this->check_path(Mage::getBaseDir('media').DS.'gallery');
                    $image_name = $uploader->getCorrectFileName($_FILES[$image_id]['name']);
                    $uploader->save($path, $image_name);
                    $image_url = 'gallery/'.$image_name;
                    $this->resize_image($path.DS.$image_name);
                    $model->setData('featured_image', $image_url);
                } else {
                    $featured_image = $this->getRequest()->getParam($image_id, null);
                    $image_url = $featured_image['value'];
                    if(!isset($featured_image['delete'])){
                        $model->setData($image_id, $image_url);
                    } else {
                        if($image_url && file_exists(Mage::getBaseDir('media').DS.$image_url)) {
                            unlink(Mage::getBaseDir('media').DS.$image_url);
                        }
                        $model->setData($image_id, null);
                    }
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
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
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

    /**
     * @param $path
     */
    protected function resize_image($path)
    {
        $image = new Varien_Image($path);
        $image->constrainOnly(true);
        $image->keepAspectRatio(true);
        $image->keepFrame(false);
        $image->keepTransparency(true);
        $image->setImageBackgroundColor(false);
        $image->backgroundColor(false);
        $image->quality(100);
        $image->setWatermarkImageOpacity(0);
        $width = Mage::getStoreConfig('blogfeed/posts/image_width');
        $height = Mage::getStoreConfig('blogfeed/posts/image_height');
        $image->resize($width, $height);
        $image->save($path);
    }


    /**
     * @param $path
     * @return mixed
     */
    protected function check_path($path)
    {
        $io = new Varien_Io_File();
        if (!$io->isWriteable($path) && !$io->mkdir($path, 0777, true)) {
            Mage::throwException(Mage::helper('adminhtml')->__("Cannot create writeable directory '%s'", $path));
        }
        return $path;
    }
}