<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 登录验证
 * Class Site
 */
class Site extends CI_Controller
{

    public function index()
    {
        $this->login();
    }

    /**
     * 商城后台登录
     */
    public function login()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('store_user_model');
            // 考虑以后链接跳转免登录进入后台，session写在这里导致不能复用
            // 如果加多一层lib，会像以前一样，lib的构造方法会引用model，但又不一样到得到，感觉lib导致更加复杂。设想一下真的有lib:
            // Controller -> Model -> Lib
            // 如果没有lib:
            // Controller -> Model
            if ($this->store_user_model->login($this->input->post('User'))) {
                exit_json(0, '登录成功', [], '/admin/store');
            }
            exit_json(1, $this->store_user_model->get_error() ?: '登录失败');
        }
        $this->load->view('admin/site/login');
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        $this->load->library('session');
        $this->session->sess_destroy();
        redirect_url('/admin/site');
    }
}
