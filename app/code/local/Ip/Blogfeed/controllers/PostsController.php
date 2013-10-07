<?php

class Ip_Blogfeed_PostsController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        if($entity_id = $this->getRequest()->getParam('posts_id', null)){
            die($entity_id);
            $post = Mage::getModel('blogfeed/posts')->load($entity_id);
            Mage::register('blogfeed_post', $post);
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->norouteAction();
        }
    }

    public function listAction()
    {
        $posts = Mage::getModel('blogfeed/posts')->getCollection();
        if($posts->count()){
            Mage::register('blogfeed_collection', $posts);
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->norouteAction();
        }
    }

}