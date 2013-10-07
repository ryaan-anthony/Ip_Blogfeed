<?php

class Ip_Blogfeed_Model_Resource_Posts extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('blogfeed/posts', 'posts_id');
    }

    public function loadByAttribute($attr, $value)
    {
        $table = $this->getMainTable();
        $read = $this->_getReadAdapter();
        $where = $read->quoteInto("$attr = ?", $value);
        $sql = $read->select()
            ->from($table, array('posts_id'))
            ->where($where);
        return $read->fetchOne($sql);
    }

}