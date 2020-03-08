<?php
/**
 * Created by PhpStorm.
 * User: 25754
 * Date: 2019/8/19
 * Time: 9:04
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Category_model extends Common_model
{
    private $_category = null;
    private $_admin = null;
    function __construct()
    {
        parent::__construct();
        $this->_category = $this->config->item("category");
        $this->_admin = $this->config->item("admin");
    }

    public function get($start = '', $limit = '')
    {
        $keyword = $this->input->post("keyword");
        //分页条件
        $condition = array($start, $limit);
        $where = '1=1 and c.is_deleted = 0';

        if ($keyword) {
            $where .= ' and c.name like "%'.$keyword.'%"';
        }

        $join[0] = array(
            $this->_admin .' as a',
            'a.id = c.user_id',
            "left"
        );
        $select = 'c.*, a.username';
        $order = array("c.id", " desc");
        $arr = $this->getAllCommon($this->_category.' as c', $where, $select, $join, $order, $condition);
        return $arr;
    }

    public function insert($post)
    {
        return $this->db->insert($this->_category, $post);
    }

    public function edit($id)
    {
        return $this->db->get_where($this->_category, "id=$id")->row_array();
    }

    public function update($post)
    {
        return $this->db->update($this->_category, $post, "id=" . $post['id']);
    }

    public function delete($id)
    {
        return $this->db->update($this->_category, array("is_deleted" => 1),array("id" => $id));
    }

    public function setStatus($id, $status)
    {
        return $this->db->update($this->_category, array("status"=>$status), "id=$id");
    }

    public function getCategory()
    {
        return $this->db->get_where($this->_category, array("is_deleted" => 0, "status" => 1))->result_array();
    }

    public function getCategoryById($catid)
    {
        return $this->db->get_where($this->_category, array("is_deleted" => 0, "status" => 1, "id" => $catid))->row_array();
    }
}