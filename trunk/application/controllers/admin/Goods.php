<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(__DIR__ . '/Controller.php');

/**
 * 商品管理控制器
 * Class Goods
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
        $list = $this->goods_model->get_list(['goods.store_id' => $this->session->store['user']['store_id']]);
//		p($list);die;
        $this->load_view(compact('list'));
    }


    /**
     * 商品分类列表
     */
    public function category_list()
    {
        $this->load->model('category_model');
        $list = $this->category_model->get_list(['store_id' => $this->session->store['user']['store_id']]);
        $list = $this->category_model->category_tree($list);
//        p($list);die;
        $this->load_view(compact('list'));
    }

    /**
     * 添加商品分类
     */
    public function category_add()
    {
        $this->load->model('category_model');
        $list = $this->category_model->get_list(['store_id' => $this->session->store['user']['store_id']]);
        $list = $this->category_model->category_tree($list);
//        p($list);die;
        $this->load_view(compact('list'));
    }
}
