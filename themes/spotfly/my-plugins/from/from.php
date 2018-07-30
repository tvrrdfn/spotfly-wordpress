<?php
wp_enqueue_media();
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-sortable');

wp_enqueue_style('my-styles', get_theme_file_uri('/style.css'), false, '1.0');
wp_enqueue_style('my-from-styles', get_theme_file_uri('/my-plugins/from/from.css'), false, '1.0');
wp_register_script('my-script', get_theme_file_uri('/common.js'), array('jquery'), '1.0', true);
wp_register_script('my-from-script', get_theme_file_uri('/my-plugins/from/from.js'), array('jquery'), '1.0', true);
wp_enqueue_script('my-script');
wp_enqueue_script('my-from-script');
?>

<div style="display: none"><svg xmlns="http://www.w3.org/2000/svg" style="position:absolute; width: 0; height: 0"><symbol viewBox="0 0 18 18" id="icon-close"><path fill="none" d="M0 0h18v18H0z"></path><path d="M10.27 9l4-4A.9.9 0 0 0 13 3.77l-4 4-4-4A.9.9 0 1 0 3.77 5l4 4-4 4A.9.9 0 1 0 5 14.23l4-4 4 4A.9.9 0 0 0 14.23 13z"></path></symbol></svg></div>

<div id="my-from__content">
    <h2>
        <span>咨询表单</span>
    </h2>

    <div class="my-from" id="my-from">
        <h3>
            咨询表单列表
            <span class="spinner"></span>
        </h3>

        <ul class="my-from__list clearfix" id="my-content__wrap">
        </ul>
    </div>
</div>
