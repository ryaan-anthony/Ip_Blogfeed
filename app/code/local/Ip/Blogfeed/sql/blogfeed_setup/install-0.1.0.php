<?php
$installer = $this;
$installer->startSetup();
$installer->run("
    DROP TABLE IF EXISTS {$installer->getTable('blogfeed/posts')};
    CREATE TABLE {$installer->getTable('blogfeed/posts')} (
        `posts_id` int(11) NOT NULL auto_increment,
        `title` varchar(255),
        `url_key` varchar(255),
        `description` text,
        `date` datetime default NULL,
        `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
        PRIMARY KEY (`posts_id`)
    );
");
$installer->endSetup();
// set default url to http://storeurl.com/blogfeed/
$backend_model = new Ip_Blogfeed_Model_Backend_Url();
$backend_model->setValue(Mage::getStoreConfig('blogfeed/posts/blog_url'));
$backend_model->save();