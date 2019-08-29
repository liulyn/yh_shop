<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(__DIR__ . '/Controller.php');

/**
 * 商城后台基类
 * Class Site
 */
class Controller extends CI_Controller
{

    /* @var array $store 商家登录信息 */
    protected $store;
    /** @var string  当前路由控制器 */
    protected $controller;
    /** @var 当前路由uri */
    protected $route_uri;
    /** @var 菜单配置 */
    protected $menus;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->store = $this->session->store;
        $this->controller = $this->router->class;
        $this->route_uri = '/' . ($this->router->directory ?: '') . $this->router->class . '/' . $this->router->method;
        $this->check_login();
        $this->menus = $this->menus();
    }

    /**
     * 验证登录状态
     * @return bool
     */
    private function check_login()
    {
        // 验证登录状态
        if (empty($this->store)
            || (int)$this->store['is_login'] !== 1
        ) {
            redirect_url('/admin/site');
            return false;
        }
        return true;
    }

    /**
     * 后台菜单配置
     * @return string|null
     */
    private function menus()
    {
        $this->config->load('menus', TRUE);
        $data = $this->config->item('menus', 'menus');
        $i = 0;
        foreach ($data as $controller => $first) {
            // 一级菜单：active
            $data[$controller]['active'] = $controller === $this->controller;
            // 遍历：二级菜单
            if (isset($first['submenu'])) {
                foreach ($first['submenu'] as $second_key => $second) {
                    // 二级菜单所有uri
                    $secondUris = [];
                    if (isset($second['submenu'])) { // 二级菜单下有三级菜单的情况
                        // 遍历：三级菜单
                        foreach ($second['submenu'] as $third_key => $third) {
                            $thirdUris = [];
                            // 同理一：有uris则uris，保证三级菜单下新的页面使用同样的active，否则取index的值
                            // 跟$secondUris合并是为了二级菜单保持active展开来，否则折叠起来就会显示少了
                            if (isset($third['uris'])) {
                                $secondUris = array_merge($secondUris, $third['uris']);
                                $thirdUris = array_merge($thirdUris, $third['uris']);
                            } else {
                                $secondUris[] = $third['index'];
                                $thirdUris[] = $third['index'];
                            }
                            $data[$controller]['submenu'][$second_key]['submenu'][$third_key]['active'] = in_array($this->route_uri, $thirdUris);
                        }
                    } else { // 二级菜单下没有三级菜单的情况，取当前二级菜单的uris或者index
                        // 同理一：有uris则uris，保证二级菜单下新的页面使用同样的active，否则取index的值
                        if (isset($second['uris']))
                            $secondUris = array_merge($secondUris, $second['uris']);
                        else
                            $secondUris[] = $second['index'];
                    }
                    // 二级菜单：active
                    !isset($data[$controller]['submenu'][$second_key]['active'])
                    && $data[$controller]['submenu'][$second_key]['active'] = in_array($this->route_uri, $secondUris);
                }
            }
            $i++;
        }
        return $data;
    }
}