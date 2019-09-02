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
		if($data['storage'] === 'local'){
			$url = '/uploads/'.$data['file_name'];
		}
		return $url;
	}

	public function get_store_list($store_id,$group_id,$file_type='image'){
        $this->db->where(['store_id'=>$store_id,'file_type' => $file_type, 'is_delete' => 0]);
        if($group_id !== -1){
            $this->db->where(compact('group_id'));
        }
        $this->db->order_by('file_id desc');
        return $this->db->get($this->table_name)->result_array();
    }
}
