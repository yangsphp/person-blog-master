<?php
/**
 * Created by PhpStorm.
 * User: 25754
 * Date: 2019/4/27
 * Time: 14:52
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->set_admin_view_dir();
        $this->load->model('category_model');
    }
    public function get() {
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        $arr = $this->category_model->get($start, $limit);
        $count = count($this->category_model->get());
        echo json_encode(array(
            'err' => 0,
            'data' => $arr,
            'total' => $count
        ));
    }
    public function index()
    {
        $add_flag = $this->checkUserButtonPrivilege('admin/category/add_op');
        $edit_flag = $this->checkUserButtonPrivilege('admin/category/edit_op');
        $delete_flag = $this->checkUserButtonPrivilege('admin/category/delete_op');
        $data['add_flag'] = $add_flag;
        $data['edit_flag'] = $edit_flag;
        $data['delete_flag'] = $delete_flag;
        $htm["layout"] = $this->load->view('category/index', $data, true);
        $this->load->view('frame',$htm);
    }

    public function add()
    {
        $id = $this->input->get("id");
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['csrf'] = $csrf;
        $info = array();
        $title = "添加栏目";
        if ($id) {
            $title = "修改栏目";
            //获取数据
            $info = $this->category_model->edit($id);
        }
        $data['data'] = $info;
        $data['id'] = $id;
        $html = $this->load->view('category/add', $data, true);
        echo json_encode(array("title" => $title, "html" => $html));
    }

    public function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post[name]', '栏目名称', 'trim|required|min_length[2]|max_length[5]', array("required" => "请输入%s", "min_length" => "%s长度最少2位", "max_length" => "%s长度至多5位"));
        if ($this->form_validation->run() == FALSE) {
            $errors = explode("\n", validation_errors());
            die(json_encode(array("code" => -1, "msg" =>  strip_tags($errors[0]))));
        }
    }

    public function add_op()
    {
        $id = $this->input->post("id");
        $post = $this->input->post("post");
        $this->validate();
        $post['update_entered'] = date("Y-m-d H:i:s", time());
        if ($id) {
            //修改
            $post['id'] = $id;
            $result = $this->category_model->update($post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => "修改栏目成功")));
            }
            die(json_encode(array("code" => 1, "msg" => "修改栏目失败")));
        }else{
            //添加
            $user = $this->session->userdata("user");
            $post['user_id'] = $user['userid'];
            $post['date_entered'] = $post['update_entered'];
            $result = $this->category_model->insert($post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => "添加栏目成功")));
            }
            die(json_encode(array("code" => 1, "msg" => "添加栏目失败")));
        }
    }

    public function edit_op()
    {
        $this->add_op();
    }

    public function delete_op() {
        $id = $this->input->get("id");
        $result = $this->category_model->delete($id);
        if ($result) {
            die(json_encode(array("code" => 0, "msg" => "删除栏目成功")));
        }
        die(json_encode(array("code" => 1, "msg" => "删除栏目失败")));
    }

    public function setStatus()
    {
        $id = $this->input->get("id");
        $status = $this->input->get("status");
        $result = $this->category_model->setStatus($id, $status);
        if ($result) {
            die(json_encode(array("code" => 0, "msg" => "状态修改成功")));
        }
        die(json_encode(array("code" => 1, "msg" => "状态修改失败")));
    }
}