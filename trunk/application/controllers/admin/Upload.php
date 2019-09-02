<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(__DIR__ . '/Controller.php');

/**
 * 文件管理控制器
 * Class upload
 */
class Upload extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 文件库列表
     * @param string $type
     * @param int $group_id
     * @return mixed
     */
    public function file_list($type = 'image', $group_id = -1)
    {
        // 分组列表
        $this->load->model('upload_group_model');
        $group_list = $this->upload_group_model->get_list(['store_id' => $this->session->store['user']['store_id'],'group_type'=>$type]);
        // 文件列表
        $this->load->model('upload_file_model');
        $file_list = $this->upload_file_model->get_store_list($this->session->store['user']['store_id'],intval($group_id), $type);
        exit_json(0,'success',compact('group_list', 'file_list'));
    }

}