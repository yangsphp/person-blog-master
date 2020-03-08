<?php
/**
 * Created by PhpStorm.
 * User: 25754
 * Date: 2019/4/3
 * Time: 12:13
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends Home_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->set_home_view_dir();
    }

    public function info()
    {
        $id = $this->input->get("id");
        $cat_id = $this->input->get("catid");
        //获取文章详情
        $content = $this->article_model->getArticleById($id);
        //获取相关
        $about = $this->article_model->getArticleListAboutThis($id, $content['keywords']);
        //获取推荐
        $recommend = $this->article_model->getArticleRecommend($cat_id);
        $data['info'] = $content;
        $data['about'] = $about;
        $data['recommend'] = $recommend;
        $htm["layout"] = $this->load->view('article/index', $data, true);
        $htm['category'] = $this->_category;
        $htm['tags'] = $this->_tags;
        $htm['clicks'] = $this->_clicks;
        $htm['tuijians'] = $this->_tuijians;
        $htm['catname'] = $this->_catname;
        $this->load->view('frame',$htm);
    }
}