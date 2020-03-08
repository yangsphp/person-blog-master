<?php
/**
 * Created by PhpStorm.
 * User: 25754
 * Date: 2019/4/3
 * Time: 12:13
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Home_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->set_home_view_dir();
        $this->load->model("article_model");
        $this->load->model("category_model");
    }

    public function index()
    {
        //获取文章列表
        $data = $this->articlePage();
        $htm["layout"] = $this->load->view('index/index', $data, true);
        $htm['category'] = $this->_category;
        $htm['tags'] = $this->_tags;
        $htm['clicks'] = $this->_clicks;
        $htm['tuijians'] = $this->_tuijians;
        $htm['catname'] = $this->_catname;
        $this->load->view('frame',$htm);
    }
}