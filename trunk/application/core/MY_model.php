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
     * 获取列表
     */
    public function get_list($where = [], $field = '*', $limit = 0, $offset = 0, $order_by = '')
    {
        $this->db->select($field);
        $this->db->from($this->table_name);
        if ($where) {
            $this->db->where($where);
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        if ($order_by) {
            $this->db->order_by($order_by);
        }
        $list = $this->db->get()->result_array();
        return $list;
    }

    /**
     * 获取单行数据
     * @param $where
     * @param string $field
     * @param string $order_by
     * @param array $join
     * @return mixed
     */
    public function get_row_by_where($where, $field = '*', $order_by = '', $join = [])
    {
        if ($order_by) {
            $this->db->order_by($order_by);
        }
        if ($join) {
            $this->db->join($join[0], $join[1], $join[2]);
        }
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
     * 删除数据
     * @param $where
     * @return bool|int
     */
    public function delete_by_where($where)
    {
        $res = $this->db->where($where)->delete($this->table_name);
        if (!$res) {
            return false;
        }
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function insert($data)
    {
        if (empty($data)) {
            return false;
        }
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id() > 0 ? $this->db->insert_id() : false;
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
