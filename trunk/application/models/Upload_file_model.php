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
}
