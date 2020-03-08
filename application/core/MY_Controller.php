<?php
/**
 * Created by PhpStorm.
 * User: 25754
 * Date: 2019/4/8
 * Time: 8:44
 */

defined('BASEPATH') OR exit('No direct script access allowed');
set_time_limit(0);

//后台公共控制
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUserLogin();
        //$this->session->unset_userdata("menuList");
        $this->load->model('common_model');
        $this->load->model('auth_model');
        $this->adminLog();
    }

    public function checkUserLogin()
    {
        $user = $this->session->userdata("user");
        if (!$user) {
            //重定向到登录页面
            redirect(site_url("admin/login/index"));
            exit();
        }
        $this->menu($user);
    }

    function random($length, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz')
    {
        $hash = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    protected function adminLog()
    {
        $uri = strtolower($this->uri->uri_string());
        //获取权限
        $auth = $this->auth_model->get(false);
        $uri_name = "";
        foreach ($auth as $k => $v) {
            if (strtolower($v['url']) == $uri) {
                $uri_name = $v['name'];
            }
        }
        if ($uri_name) {
            $this->load->helper('cookie');
            if ($uri != 'admin/log/index') {
                $log_string = get_cookie('log_string');
                $md5_string = md5($uri_name);
                if ($log_string != $md5_string) {
                    $user = $this->session->userdata("user");
                    $data = array(
                        'user_id' => $user['userid'],
                        '_id' => isset($_REQUEST['id']) ? $_REQUEST['id'] : 0,
                        'name' => $uri_name,
                        'date_entered' => date("Y-m-d H:i:s")
                    );
                    if ($this->common_model->insertAdminLog($data)) {
                        set_cookie("log_string", $md5_string, 86500);
                    }
                }
            }
        }
    }

    protected function menu($user)
    {
        $_admin = $this->config->item("admin");
        $_auth = $this->config->item("auth");
        $_role = $this->config->item("role");

        //获取导航栏
        $role = $this->db->select("r.name as role_name, r.auth")->from($_admin . " as a")->join($_role . " as r", "r.id = a.role_id", "left")->where("a.status = 1 and a.id=" . $user['userid'])->get()->row_array();
        $where = "is_menu=1 and status=1";
        if ($user['userid'] != 1) {
            $where .= " and id in({$role['auth']})";
        }
        $data = $this->db->where($where)->order_by("sort", "asc")->get($_auth)->result_array();
        $menuHtml = $this->getMenuHtml($data);
        $menuUrl = array();
        $where = "is_menu=0 and status=1";
        if ($user['userid'] != 1) {
            $where .= " and id in({$role['auth']})";
        }
        $data = $this->db->where($where)->order_by("sort", "asc")->get($_auth)->result_array();
        foreach ($data as $k => $v) {
            $menuUrl[] = $v['url'];
        }
        $user['role_name'] = $role['role_name'];
        $this->session->set_userdata("menuUrl", $menuUrl);
        $this->session->set_userdata("menuHtml", $menuHtml);
        $this->session->set_userdata("user", $user);
    }

    protected function getMenuHtml($data, $parent_id = 0)
    {
        $uri = strtolower($this->uri->uri_string());
        $html = "";
        foreach ($data as $k => $v) {
            if ($v["parent_id"] == $parent_id) {
                $childHtml = $this->getMenuHtml($data, $v['id']);
                $right = $treeview = $active = "";
                $url = site_url($v['url']);
                if ($childHtml) {
                    $right = '<i class="fa pull-right fa-angle-right"></i>';
                    $treeview = "treeview";
                    $url = "#";
                }
                if (strtolower($v['url']) == $uri) {
                    $active = "active";
                }
                $html .= "<li data-id='" . $v['id'] . "' data-pid='" . $v['parent_id'] . "' class='" . $treeview . " " . $active . "'><a href='" . $url . "'><i class='" . $v['icon'] . "'></i><span>" . $v['name'] . "</span>" . $right . "</a>";
                $html .= $childHtml;
                $html = $html . "</li>";
            }
        }
        if ($parent_id == 0) {
            $ulClass = "sidebar-menu";
        } else {
            $ulClass = "treeview-menu";
        }
        return $html ? '<ul id="ul-' . $parent_id . '" class="' . $ulClass . '">' . $html . '</ul>' : $html;
    }

    /**
     * 用户按钮权限判断
     * @param $url
     * @return bool
     */
    public function checkUserButtonPrivilege($url)
    {
        $menuUrl = $this->session->userdata("menuUrl");
        if (in_array($url, $menuUrl)) {
            return true;
        }
        return false;
    }
}

//前台公共控制
class Home_Controller extends CI_Controller
{
    protected $_category = null;
    protected $_tags = null;
    protected $_clicks = null;
    protected $_tuijians = null;
    protected $_catname = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->load->model("category_model");
        $this->load->model("tags_model");
        $this->load->model("article_model");
        $this->_category = $this->category_model->getCategory();
        $this->_tags = $this->tags_model->getTags();
        $this->_clicks = $this->article_model->getClickArticle(8);
        $this->_tuijians = $this->article_model->getTuiJianArticle(8);
        $cat_id = $this->input->get("catid");
        if ($cat_id)
        {
            $catinfo = $this->category_model->getCategoryById($cat_id);
            $this->_catname = $catinfo['name'];
        }else{
            $this->_catname = "";
        }
    }

    public function articlePage()
    {
        $cat_id = $this->input->get("catid");
        $search = $this->input->get("search");
        $current_page = intval($this->input->get("per_page")); //获取当前分页页码数
        $this->load->library('pagination');//加载分页库
        $count = $this->article_model->getArticleCount($cat_id, $search);
        $config['base_url'] = site_url('home/index/index?catid='.$cat_id.'&search='.$search);
        $config['total_rows'] = $count;
        $config['per_page'] = 20;

        $config['num_links'] = 3;

        $config['first_link'] = '首页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '末页';

        $config['full_tag_open'] = '<ul class="">';
        $config['full_tag_close'] = '</ul>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="thisclass">';
        $config['cur_tag_close'] = '</a></li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['page_query_string'] = true;
        $this->pagination->initialize($config);

        $data['article'] = $this->article_model->getArticleByPage($current_page, $config['per_page'], $cat_id, $search);
        $data['link'] = $this->pagination->create_links();
        $data['catid'] = $cat_id;
        return $data;
    }
}
