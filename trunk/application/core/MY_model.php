<?php


class MY_model extends CI_Model
{
    protected $CI;
    /** @var 错误信息 */
    protected $error;
    /** @var 表名 */
    protected $table_name;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->CI->load->database();
    }

    /**
     * 获取单行数据
     * @param $where
     * @param string $field
     * @return mixed
     */
    public function get_row_by_where($where, $field = '*')
    {
        return $this->db->select($field)->from($this->table_name)->where($where)->get()->row_array();
    }

    /**
     * 更新数据
     * @param $where
     * @param $data
     * @return bool|int
     */
    public function update_by_where($where, $data)
    {
        $res = $this->db->where($where)->update($this->table_name, $data);
        if (!$res) {
            return false;
        }
        return $this->db->affected_rows() > 0 ? true : false;
    }

    /**
     * 返回模型的错误信息
     * @access public
     * @return string|array
     */
    public function get_error()
    {
        return $this->error;
    }

}
