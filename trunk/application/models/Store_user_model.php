<?php


class Store_user_model extends MY_model
//class Store_user_model extends CI_Model
{
    /** @var string 表名 */
    protected $table_name = 'store_user';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 商城后台登录
     * @param $data
     * @return mixed
     */
    public function login($data)
    {
        if (!$res = $this->get_row_by_where([
            'user_name' => $data['user_name'],
            'password' => shop_hash($data['password'])
        ])
        ) {
            $this->error = '登录失败，用户名或密码错误';
            return false;
        }
        $this->CI->load->library('session');
        $this->CI->session->store = [
            'user' => [
                'store_user_id' => $res['store_user_id'],
                'user_name' => $res['user_name'],
            ],
            'is_login' => true,
        ];
        return true;
    }

    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    public function renew($store_user_id, $data)
    {
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '密码不一致';
            return false;
        }
        // 更新管理员信息
        if ( !$this->update_by_where(['store_user_id' => $store_user_id], [
            'password' => shop_hash($data['password']),
            'update_time' => time(),
        ])) {
            $this->error = '更新数据库失败';
            return false;
        }
        return true;
    }
}
