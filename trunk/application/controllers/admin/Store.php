<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(__DIR__ . '/Controller.php');

/**
 * 商城后台
 * Class Store
 */
class Store extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 商城后台首页
     */
    public function index()
    {
        $this->load_view();
    }

    /**
     * 更新当前管理员信息
     */
    public function renew()
    {
        $this->load->model('store_user_model');
        if ($this->input->is_ajax_request()) {
            if ($this->store_user_model->renew($this->store['user']['store_user_id'], $this->input->post('user'))) {
                exit_json(0, '提交成功', [], '');
            }
            exit_json(1, $this->store_user_model->get_error()?:'提交失败');
        }
        $model = $this->store_user_model->get_row_by_where([
                'store_user_id' => $this->store['user']['store_user_id']
            ]
        );
        $this->load_view(compact('model'));
    }
}