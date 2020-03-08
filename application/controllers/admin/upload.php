<?php
/**
 * Created by PhpStorm.
 * User: 25754
 * Date: 2020/3/5
 * Time: 15:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
    public function doUpload()
    {
        $width = $this->input->post("width");
        $height = $this->input->post("height");
        $config['upload_path'] = './upload/img/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2 * 1024 * 1024;
        // $config['max_width'] = 1024;
        // $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            die(json_encode(array("code" => 1, "error" => $error)));
        } else {
            $data = array('upload_data' => $this->upload->data());
            $config['image_library'] = 'gd2';
            $config['source_image'] = './upload/img/' . $data['upload_data']['file_name'];
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = $width;
            $config['height'] = $height;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $path = "/upload/img/" . $data['upload_data']['raw_name'] . '_thumb' . $data['upload_data']['file_ext'];
            die(json_encode(array("code" => 0, "path" => $path)));
        }
    }
}