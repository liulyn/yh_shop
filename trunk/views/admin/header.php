<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>微商城</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="/assets/store/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="微商城"/>
    <link rel="stylesheet" href="/assets/store/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/assets/store/css/app.css"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_t6knt0guzo.css">
    <script src="/assets/store/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <script>
        //BASE_URL = '<?//= isset($base_url) ? $base_url : '' ?>//';
        STORE_URL = '<?= isset($store_url) ? $store_url : '' ?>';
    </script>
</head>

<body data-type="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <div class="am-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <!-- 刷新页面 -->
            <div class="am-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="/admin/store/renew">欢迎你，<span><?= $_SESSION['store']['user']['user_name'] ?></span>
                        </a>
                    </li>
                    <!-- 退出 -->
                    <li class="am-text-sm">
                        <a href="/admin/site/logout">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar">
        <?php $menus = isset($menus) ? $menus : []; ?>
        <?php $controller = isset($controller) ? $controller : 0; ?>
        <!-- 一级菜单 -->
        <ul class="sidebar-nav">
            <li class="sidebar-nav-heading">微商城</li>
            <?php foreach ($menus as $key => $item): ?>
                <li class="sidebar-nav-link">
                    <a href="<?= isset($item['index']) ? $item['index'] : 'javascript:void(0);' ?>"
                       class="<?= $item['active'] ? 'active' : '' ?>">
                        <?php if (isset($item['is_svg']) && $item['is_svg'] === true): ?>
                            <svg class="icon sidebar-nav-link-logo" aria-hidden="true">
                                <use xlink:href="#<?= $item['icon'] ?>"></use>
                            </svg>
                        <?php else: ?>
                            <i class="iconfont sidebar-nav-link-logo <?= $item['icon'] ?>"
                               style="<?= isset($item['color']) ? "color:{$item['color']};" : '' ?>"></i>
                        <?php endif; ?>
                        <?= $item['name'] ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <!--            <li class="sidebar-nav-link">-->
            <!--                <a href="index.php?s=/store/index/index" class="active">-->
            <!--                    <i class="iconfont sidebar-nav-link-logo icon-home" style=""></i>-->
            <!--                    首页                    </a>-->
            <!--            </li>-->
            <!--            <li class="sidebar-nav-link">-->
            <!--                <a href="index.php?s=/store/goods/index" class="">-->
            <!--                    <i class="iconfont sidebar-nav-link-logo icon-goods" style=""></i>-->
            <!--                    商品管理                    </a>-->
            <!--            </li>-->
            <!--            <li class="sidebar-nav-link">-->
            <!--                <a href="index.php?s=/store/order/delivery_list" class="">-->
            <!--                    <i class="iconfont sidebar-nav-link-logo icon-order" style=""></i>-->
            <!--                    订单管理                    </a>-->
            <!--            </li>-->
            <!--            <li class="sidebar-nav-link">-->
            <!--                <a href="index.php?s=/store/user/index" class="">-->
            <!--                    <i class="iconfont sidebar-nav-link-logo icon-user" style=""></i>-->
            <!--                    用户管理                    </a>-->
            <!--            </li>-->
            <!--            <li class="sidebar-nav-link">-->
            <!--                <a href="index.php?s=/store/wxapp/setting" class="">-->
            <!--                    <i class="iconfont sidebar-nav-link-logo icon-wxapp" style="color:#36b313;"></i>-->
            <!--                    小程序                    </a>-->
            <!--            </li>-->
            <!--            <li class="sidebar-nav-link">-->
            <!--                <a href="javascript:void(0);" class="">-->
            <!--                    <svg class="icon sidebar-nav-link-logo" aria-hidden="true">-->
            <!--                        <use xlink:href="#icon-application"></use>-->
            <!--                    </svg>-->
            <!--                    应用中心                    </a>-->
            <!--            </li>-->
            <!--            <li class="sidebar-nav-link">-->
            <!--                <a href="index.php?s=/store/setting/store" class="">-->
            <!--                    <i class="iconfont sidebar-nav-link-logo icon-setting" style=""></i>-->
            <!--                    设置                    </a>-->
            <!--            </li>-->
        </ul>
        <!-- 子级菜单-->
        <?php $second = isset($menus[$controller]['submenu']) ? $menus[$controller]['submenu'] : []; ?>
        <?php if (!empty($second)) : ?>
            <ul class="left-sidebar-second">
                <li class="sidebar-second-title"><?= $menus[$controller]['name'] ?></li>
                <li class="sidebar-second-item">
                    <?php foreach ($second as $item) : ?>
                        <?php if (!isset($item['submenu'])): ?>
                            <!-- 二级菜单-->
                            <a href="<?=$item['index']?>" class="<?= $item['active'] ? 'active' : '' ?>">
                                <?= $item['name']; ?>
                            </a>
                        <?php else: ?>
                            <!-- 三级菜单-->
                            <div class="sidebar-third-item">
                                <a href="javascript:void(0);"
                                   class="sidebar-nav-sub-title <?= $item['active'] ? 'active' : '' ?>">
                                    <i class="iconfont icon-caret"></i>
                                    <?= $item['name']; ?>
                                </a>
                                <ul class="sidebar-third-nav-sub">
                                    <?php foreach ($item['submenu'] as $third) : ?>
                                        <li>
                                            <a class="<?= $third['active'] ? 'active' : '' ?>"
                                               href="<?= $third['index'] ?>">
                                                <?= $third['name']; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?= empty($second) ? 'no-sidebar-second' : '' ?>">


