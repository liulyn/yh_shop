<?php


class Upload_group_model extends MY_model
{
    /** @var string 表名 */
    protected $table_name = 'upload_group';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 删除文件分组
     * @param $store_id
     * @param $group_id
     * @return bool
     */
    public function delete_store_group($store_id, $group_id)
    {
        $this->CI->load->model('upload_file_model');
        $where = ['store_id' => $store_id, 'group_id' => $group_id];
        $data = ['group_id' => 0];
        $this->CI->upload_file_model->update_by_where($where, $data);
        if (!$this->delete_by_where($where)) {
            return false;
        }
        return true;
    }

}
