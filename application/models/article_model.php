<?php
/**
 * Created by PhpStorm.
 * User: 25754
 * Date: 2019/8/19
 * Time: 9:04
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends Common_model
{
    private $_article = null;
    private $_admin = null;
    private $_category = null;

    function __construct()
    {
        parent::__construct();
        $this->_article = $this->config->item("article");
        $this->_admin = $this->config->item("admin");
        $this->_category = $this->config->item("category");
    }

    public function get($start = '', $limit = '')
    {
        $keyword = $this->input->post("keyword");
        //分页条件
        $condition = array($start, $limit);
        $where = '1=1 and c.is_deleted = 0';

        if ($keyword) {
            $where .= ' and c.title like "%' . $keyword . '%"';
        }

        $join[0] = array(
            $this->_admin . ' as a',
            'a.id = c.user_id',
            "left"
        );
        $join[1] = array(
            $this->_category . ' as cg',
            'cg.id = c.category_id',
            "left"
        );
        $select = 'c.*, a.username, cg.name';
        $order = array("c.id", " desc");
        $arr = $this->getAllCommon($this->_article . ' as c', $where, $select, $join, $order, $condition);
        return $arr;
    }

    public function insert($post)
    {
        return $this->db->insert($this->_article, $post);
    }

    public function edit($id)
    {
        return $this->db->get_where($this->_article, "id=$id")->row_array();
    }

    public function update($post)
    {
        return $this->db->update($this->_article, $post, "id=" . $post['id']);
    }

    public function delete($id)
    {
        return $this->db->update($this->_article, array("is_deleted" => 1), array("id" => $id));
    }

    public function setStatus($id, $status)
    {
        return $this->db->update($this->_article, array("status" => $status), "id=$id");
    }

    public function setState($id, $status)
    {
        return $this->db->update($this->_article, array("state" => $status), "id=$id");
    }

    public function getClickArticle($limit)
    {
        $this->db->limit($limit);
        $this->db->order_by("click", "desc");
        return $this->db->get_where($this->_article, array("is_deleted" => 0, "status" => 1))->result_array();
    }

    public function getTuiJianArticle($limit)
    {
        $this->db->limit($limit);
        return $this->db->get_where($this->_article, array("is_deleted" => 0, "status" => 1, "state" => 1))->result_array();
    }

    public function getArticleCount($cat_id, $search)
    {
        $where = "status = 1 and is_deleted = 0";
        if ($cat_id) {
            $where .= " and category_id = $cat_id";
        }
        if ($search) {
            $where .= " and title like '%{$search}%'";
        }
        return $this->db->where($where)->count_all_results($this->_article);
    }

    public function getArticleByPage($offset, $per_page_nums, $cat_id, $search)
    {
        $where = "a.status = 1 and a.is_deleted = 0";
        if ($cat_id) {
            $where .= " and a.category_id = $cat_id";
        }
        if ($search) {
            $where .= " and a.title like '%{$search}%'";
        }
        return $this->db->select("a.*,c.name")
            ->from($this->_article . " as a")
            ->join($this->_category . " as c", "c.id = a.category_id", "left")
            ->where($where)
            ->order_by("a.id", "desc")
            ->limit($per_page_nums, $offset)
            ->get()->result_array();
    }

    public function getArticleById($id)
    {
        return $this->db->get_where($this->_article, "id = $id")->row_array();
    }

    public function getArticleListAboutThis($id, $keywords)
    {
        $arr = explode(',', $keywords);
        static $about = array();
        foreach ($arr as $k => $v) {
            $articles = $this->db->select("*")->from($this->_article)->where("id != $id and is_deleted = 0 and status = 1 and keywords like '%{$v}%'")
                ->limit(8)
                ->order_by("id", "desc")
                ->get()->result_array();
            $about = array_merge($about, $articles);
        }
        if ($about) {
            $about =  $this->arr_unique($about);
        }
        return $about;
    }

    public function arr_unique($arr2d){
        $ids = array();
        $return = array();
        foreach ($arr2d as $k=>$v) {
            if (!in_array($v['id'], $ids)) {
                $ids[] = $v['id'];
                $return[] = $v;
            }
        }
        return $return;
    }

    public function getArticleRecommend($cat_id)
    {
        return $this->db->where("category_id != $cat_id and is_deleted = 0 and status = 1 and state = 1")->limit(8)->get($this->_article)->result_array();
    }
}