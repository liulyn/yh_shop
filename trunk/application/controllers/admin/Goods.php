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
        $this->load_view();
    }
}