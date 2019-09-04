<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 微信小程序
 * Class Wxapp
 */
class Wxapp extends CI_Controller
{
    /**
     * 小程序基础信息
     */
    public function base()
    {
//        $wxapp = WxappModel::getWxappCache();
        $wxapp = [
            'navbar' => [
                'wxapp_title' => 'xxx',
                'top_text_color' => [
                    'text' => '#ffffff',
                    'value' => 20,
                ],
                'top_background_color' => '#00a92c',
            ],
        ];
        exit_json(0, 'success', compact('wxapp'));
    }
}