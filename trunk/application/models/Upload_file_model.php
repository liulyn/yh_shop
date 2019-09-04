<?php


class Upload_file_model extends MY_model
{
    /** @var string 表名 */
    protected $table_name = 'upload_file';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 文件url
     * @param $data
     * @return string
     */
    public function get_url($data)
    {
        $url = $data['file_url'];
        if ($data['storage'] === 'local') {
            $url = '/uploads/' . $data['file_name'];
        }
        return $url;
    }

    /**
     * 获取文件列表
     * @param $store_id
     * @param $group_id
     * @param string $file_type
     * @param int $page
     * @return array
     */
    public function get_store_list($store_id, $group_id, $file_type = 'image', $page = 1)
    {
        $this->db->start_cache();
        $this->db->where(['store_id' => $store_id, 'file_type' => $file_type, 'is_delete' => 0]);
        if ($group_id !== -1) {
            $this->db->where(compact('group_id'));
        }
        $this->db->stop_cache();
        $count_result = $this->db->count_all_results($this->table_name);
        $limit = 32;
        $this->db->limit($limit);
        $this->db->offset((($page ?: 1) - 1) * $limit);
        $this->db->order_by('file_id desc');
        $result = $this->db->get($this->table_name)->result_array();
        $this->db->flush_cache();
        foreach ($result as $key => &$item) {
            $item['file_path'] = $this->get_url($item);
        }
        unset($item);
        $data = [
            'current_page' => intval($page ?: 1),
            'data' => $result,
            'last_page' => ceil($count_result / $limit),
            'per_page' => $limit,
            'total' => $count_result,
        ];
        return $data;
    }

    /**
     * 批量移动文件分组
     * @param $store_id
     * @param $group_id
     * @param $file_id
     * @return bool
     */
    public function move_group($store_id, $group_id, $file_id)
    {
        $this->db->where('store_id', $store_id);
        if (is_array($file_id)) {
            $this->db->where_in('file_id', $file_id);
        } else {
            $this->db->where('file_id', $file_id);
        }
        $this->db->update($this->table_name, ['group_id' => $group_id]);
        return $this->db->affected_rows() >= 0 ? true : false;
    }

    /**
     * 批量软删除
     * @param $store_id
     * @param $file_id
     * @return bool
     */
    public function soft_delete($store_id,$file_id)
    {
        $this->db->where('store_id', $store_id);
        if (is_array($file_id)) {
            $this->db->where_in('file_id', $file_id);
        } else {
            $this->db->where('file_id', $file_id);
        }
        $this->db->update($this->table_name, ['is_delete' => 1]);
        return $this->db->affected_rows() > 0 ? true : false;
    }
}
