<?php
wp_enqueue_media();
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-sortable');

wp_enqueue_style('my-styles', get_theme_file_uri('/style.css'), false, '1.0');
wp_enqueue_style('my-content-styles', get_theme_file_uri('/my-plugins/video/video.css'), false, '1.0');
wp_register_script('my-script', get_theme_file_uri('/common.js'), array('jquery'), '1.0', true);
wp_register_script('my-content-script', get_theme_file_uri('/my-plugins/video/video.js'), array('jquery'), '1.0', true);
wp_enqueue_script('my-script');
wp_enqueue_script('my-content-script');
?>

<div style="display: none"><svg xmlns="http://www.w3.org/2000/svg" style="position:absolute; width: 0; height: 0"><symbol viewBox="0 0 18 18" id="icon-close"><path fill="none" d="M0 0h18v18H0z"></path><path d="M10.27 9l4-4A.9.9 0 0 0 13 3.77l-4 4-4-4A.9.9 0 1 0 3.77 5l4 4-4 4A.9.9 0 1 0 5 14.23l4-4 4 4A.9.9 0 0 0 14.23 13z"></path></symbol></svg></div>

<div>
    <h2>
        <span>资料下载设置</span>
    </h2>

    <div class="my-content" id="my-content">
        <h3>
            资料下载列表
            <button class="button-primary my-content__add">添加资料</button>
            <span class="spinner"></span>
        </h3>

        <ul class="my-content__list clearfix" id="my-content__wrap">
            <!-- <li class="con_list_item first_row default_list">
                <div class="list_item_top">
                    <div class="position">
                        <div class="p_top">
                            <a class="position_link">
                                <h3 class="js_name">2018.7.19早盘行情分析</h3>
                            </a>
                        </div>
                        <div class="p_bot">
                            <div class="li_b_l">
                                显示顺序：<span class="js_order">3</span>
                            </div>
                        </div>
                    </div>
                    <div class="com_logo">
                        <img src="" alt="team.name">
                    </div>
                </div>
                <div class="list_item_bot">
                    <div class="li_b_l">
                        <a class="my-job__delete-btn">删 除</a>
                        <a class="my-job__update-btn">更 新</a>
                    </div>
                </div>
            </li> -->
        </ul>
    </div>

    <!-- 添加或更新弹框 -->
    <div class="popup" id="my-content__popup">
        <!--
        <div class="popup__content">
            <a class="popup__close">
                <svg><use xlink:href="#icon-close"></use></svg>
            </a>

            <header class="popup__header">
                <h3>
                    - <span>更新招聘</span> -
                </h3>
            </header>

            <div class="popup__main">
                <ul class="my-content__popup-ul">
                    <li class="clearfix">
                        <div class="label">
                            职位标题:
                        </div>
                        <div class="value">
                            <input class="my-input" type="text" name="name">
                        </div>
                    </li>
                    <li class="clearfix">
                        <div class="label">
                            显示顺序:
                        </div>
                        <div class="value">
                            <input class="my-input" type="text" name="order">
                        </div>
                    </li>
                </ul>
            </div>

            <footer class="popup__footer">
                <button type="button" class="my-button btn_left">
                    <span>取消</span>
                </button>
                <button type="button" class="my-button primary btn_right">
                    <span>保存</span>
                </button>
            </footer>
        </div>
        -->
    </div>
</div>
