<?php

class Ip_Blogfeed_Model_Posts extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('blogfeed/posts');
    }

    public function setRequestPath()
    {
        $frontName = Mage::getConfig()->getNode('frontend/routers/blogfeed/args/frontName');
        $id_path = $frontName.'/'.$this->getPostsId();
        $target_path = $frontName.'/posts/index/posts_id/'.$this->getPostsId();
        //delete if already exists
        $exists = Mage::getModel('core/url_rewrite')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->loadByIdPath($id_path);

        if($exists && $exists->getIdPath()){
            $exists->delete();
        }
        //save new
        Mage::getModel('core/url_rewrite')->setIsSystem(0)
            ->setOptions('')
            ->setIdPath($id_path)
            ->setTargetPath($target_path)
            ->setRequestPath(Mage::getStoreConfig('blogfeed/posts/blog_url').'/'.$this->getUrlKey())
            ->save();
    }

    public function getPostUrl()
    {
        return Mage::getUrl(Mage::getStoreConfig('blogfeed/posts/blog_url').'/'.$this->getUrlKey());
    }

    public function getShortDescription()
    {
        $stripped = strip_tags($this->getDescription());
        return substr($stripped, 0, 200).'...';
    }

    public function isUpdated()
    {
        return $this->getDate() != $this->getTimestamp();
    }

}