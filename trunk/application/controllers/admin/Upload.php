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
     * @return mixed
     */
    public function file_list($type = 'image')
    {
        $group_id = $this->input->get('group_id');
        // 分组列表
        $this->load->model('upload_group_model');
        $group_list = $this->upload_group_model->get_list(['store_id' => $this->session->store['user']['store_id'], 'group_type' => $type]);
        // 文件列表
        $this->load->model('upload_file_model');
        $file_list = $this->upload_file_model->get_store_list($this->session->store['user']['store_id'], intval($group_id), $type, $this->input->get('page'));
        exit_json(0, 'success1', compact('group_list', 'file_list'));
    }

    /**
     * 编辑文件分组名称
     */
    public function edit_group()
    {
        $post = $this->input->post();
        if (empty($post)) {
            exit_json(1, '参数不能为空');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_data($post);
        $this->form_validation->set_rules('group_id', '分组id', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('group_name', '分组名称', 'required');
        $this->form_validation->run();
        $error_array = $this->form_validation->error_array();
        if ($error_array) {
            exit_json(1, current($error_array));
        }
        $this->load->model('upload_group_model');
        $where = ['store_id' => $this->session->store['user']['store_id'], 'group_id' => $post['group_id']];
        $data = ['group_name' => $post['group_name']];
        $result = $this->upload_group_model->update_by_where($where, $data);
        if (!$result) {
            exit_json(1, $this->upload_group_model->get_error() ?: '修改失败');
        }
        exit_json(0, '修改成功');
    }

    /**
     * 新增文件分组
     */
    public function add_group()
    {
        $post = $this->input->post();
        if (empty($post)) {
            exit_json(1, '参数不能为空');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_data($post);
        $this->form_validation->set_rules('group_type', '分组文件类型', 'required');
        $this->form_validation->set_rules('group_name', '分组名称', 'required');
        $this->form_validation->run();
        $error_array = $this->form_validation->error_array();
        if ($error_array) {
            exit_json(1, current($error_array));
        }
        $this->load->model('upload_group_model');
        $data = [
            'store_id' => $this->session->store['user']['store_id'],
            'group_type' => trim($post['group_type']),
            'group_name' => trim($post['group_name']),
            'sort' => 100,
            'create_time' => time(),
        ];
        $result = $this->upload_group_model->insert($data);
        if (!$result) {
            exit_json(1, $this->upload_group_model->get_error() ?: '添加失败');
        }
        $data = ['group_id' => $result, 'group_name' => $post['group_name']];
        exit_json(0, '添加成功', $data);
    }

    /**
     * 删除文件分组
     */
    public function delete_group()
    {
        $post = $this->input->post();
        if (empty($post)) {
            exit_json(1, '参数不能为空');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_data($post);
        $this->form_validation->set_rules('group_id', '分组id', 'required');
        $this->form_validation->run();
        $error_array = $this->form_validation->error_array();
        if ($error_array) {
            exit_json(1, current($error_array));
        }
        $this->load->model('upload_group_model');
        $result = $this->upload_group_model->delete_store_group($this->session->store['user']['store_id'], $post['group_id']);
        if (!$result) {
            exit_json(1, $this->upload_group_model->get_error() ?: '删除失败');
        }
        exit_json(0, '删除成功');
    }

    /**
     * 批量移动文件分组
     */
    public function move_files()
    {
        $post = $this->input->post();
        if (empty($post)) {
            exit_json(1, '参数不能为空');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_data($post);
        $this->form_validation->set_rules('group_id', '分组id', 'required');
//        $this->form_validation->set_rules('fileIds', '文件列表id', 'required'); // 不支持验证数组
        $this->form_validation->run();
        $error_array = $this->form_validation->error_array();
        if ($error_array) {
            exit_json(1, current($error_array));
        }
        if (empty($post['fileIds'])) {
            exit_json(1, '文件列表id不能为空');
        }
        $this->load->model('upload_file_model');
        $result = $this->upload_file_model->move_group($this->session->store['user']['store_id'], $post['group_id'], $post['fileIds']);
        if (!$result) {
            exit_json(1, $this->upload_file_model->get_error() ?: '移动失败');
        }
        exit_json(0, '移动成功');
    }

    /**
     * 批量删除文件
     */
    public function delete_files()
    {
        $post = $this->input->post();
        if (empty($post)) {
            exit_json(1, '参数不能为空');
        }
        if (empty($post['fileIds'])) {
            exit_json(1, '文件列表id不能为空');
        }
        $this->load->model('upload_file_model');
        $result = $this->upload_file_model->soft_delete($this->session->store['user']['store_id'], $post['fileIds']);
        if (!$result) {
            exit_json(1, $this->upload_file_model->get_error() ?: '删除失败');
        }
        exit_json(0, '删除成功');
    }

    /**
     * 图片上传接口
     * @param int $group_id
     * @return array
     * @throws \think\Exception
     */
    public function image()
    {
        p($this->input->post());
        p($_FILES);
        die;
        // 实例化存储驱动
        $StorageDriver = new StorageDriver($this->config);
        // 上传图片
        if (!$StorageDriver->upload())
            return json(['code' => 0, 'msg' => '图片上传失败' . $StorageDriver->getError()]);
        // 图片上传路径
        $fileName = $StorageDriver->getFileName();
        // 图片信息
        $fileInfo = $StorageDriver->getFileInfo();
        // 添加文件库记录
        $uploadFile = $this->addUploadFile($group_id, $fileName, $fileInfo, 'image');
        // 图片上传成功
        return json(['code' => 1, 'msg' => '图片上传成功', 'data' => $uploadFile]);
    }
}