<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(__DIR__ . '/Controller.php');

/**
 * 商品管理
 * Class Store
 */
class Goods extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 商城后台首页
     */
    public function index()
    {
        $data = [
            'controller' => $this->controller,
            'menus' => $this->menus
        ];
        $this->load->view('/admin/store/header', $data);
        $this->load->view('/admin/store/index');
        $this->load->view('/admin/store/footer');
    }
}