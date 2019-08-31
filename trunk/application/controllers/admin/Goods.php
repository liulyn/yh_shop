<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(__DIR__ . '/Controller.php');

/**
 * 商品管理控制器
 * Class Store
 */
class Goods extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 商品列表
     */
    public function index()
    {
    	$this->load->model('goods_model');
		$list = $this->goods_model->get_list();
//		p($list);die;
        $this->load_view(compact('list'));
    }
}
