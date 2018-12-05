<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage TEST
 * @since 1.0
 */

@ini_set('upload_max_size', '200M');
@ini_set('post_max_size', '200M');
@ini_set('max_execution_time', '300');

if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
}

//修改后台显示更新的代码
add_filter('pre_site_transient_update_core', create_function('$a', "return null;")); // 关闭核心提示
add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提示
add_filter('pre_site_transient_update_themes', create_function('$a', "return null;")); // 关闭主题提示
remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
remove_action('admin_init', '_maybe_update_core'); // 禁止 WordPress 检查更新
remove_action('admin_init', '_maybe_update_themes'); // 禁止 WordPress 更新主题

//移除后台无用的菜单
add_action('admin_menu', function () {
	// remove_menu_page('index.php'); //仪表盘
	remove_menu_page('upload.php'); //多媒体
	// remove_menu_page('edit.php?post_type=page'); //页面
	remove_menu_page('edit-comments.php'); //评论
	remove_menu_page('plugins.php'); //插件
	remove_menu_page('tools.php'); //工具
	remove_menu_page('options-general.php'); //设置
	remove_menu_page('users.php'); //用户
	remove_menu_page('themes.php'); //模板
});

//增加控制台Widget
if (!function_exists('add_dashboard_widgets')):
	function welcome_dashboard_widget_function() {
		echo "<ul><li><a href='post-new.php'>添加文章</a></li><li><a href='edit.php'>查看文章列表</a></li></ul>";
	}
	function add_dashboard_widgets() {
		wp_add_dashboard_widget('welcome_dashboard_widget', '文章管理', 'welcome_dashboard_widget_function');
	}
	add_action('wp_dashboard_setup', 'add_dashboard_widgets');

	function welcome_team_widget_function() {
		echo "<ul><li><a href='admin.php?page=my-from'>查看信息背景表</a></li></ul>";
	}
	function add_team_widgets() {
		wp_add_dashboard_widget('welcome_team_widget', '提交信息', 'welcome_team_widget_function');
	}
	add_action('wp_dashboard_setup', 'add_team_widgets');
endif;

//去除小工具Widgets
function remove_some_wp_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', remove_some_wp_widgets, 1);

//删除 WordPress 后台仪表盘组件
function disable_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}
add_action('wp_dashboard_setup', 'disable_dashboard_widgets', 999);

//删除顶级菜单
function remove_menus() {
	global $menu;
	$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
	end($menu);
	while (prev($menu)) {
		$value = explode(' ', $menu[key($menu)][0]);
		if (in_array($value[0] != NULL ? $value[0] : "", $restricted)) {unset($menu[key($menu)]);}
	}
}
if (is_admin()) {
	//add_action('admin_menu', 'remove_menus');
}

//隐藏【显示选项】
function remove_screen_options() {return false;}
add_filter('screen_options_show_screen', 'remove_screen_options');

//隐藏【帮助选项】
add_filter('contextual_help', 'wpse50723_remove_help', 999, 3);
function wpse50723_remove_help($old_help, $screen_id, $screen) {
	$screen->remove_help_tabs();
	return $old_help;
}

//精简WordPress前后台顶部工具栏
function my_edit_toolbar($wp_toolbar) {
	$wp_toolbar->remove_node('wp-logo'); //去掉Wordpress LOGO
	// $wp_toolbar->remove_node('site-name'); //去掉网站名称
	$wp_toolbar->remove_node('updates'); //去掉更新提醒
	$wp_toolbar->remove_node('comments'); //去掉评论提醒
	$wp_toolbar->remove_node('new-content'); //去掉新建文件
	//$wp_toolbar->remove_node('top-secondary'); //用户信息
}
add_action('admin_bar_menu', 'my_edit_toolbar', 999);

//删除子菜单
function remove_submenus() {
	global $submenu;
	unset($submenu['index.php'][10]); // Removes 'Updates'.
	unset($submenu['themes.php'][5]); // Removes 'Themes'.
	unset($submenu['options-general.php'][15]); // Removes 'Writing'.
	unset($submenu['options-general.php'][25]); // Removes 'Discussion'.
	unset($submenu['edit.php'][16]); // Removes 'Tags'.
}
add_action('admin_menu', 'remove_submenus');

//修改后台LOGO图标
function custom_logo() {
	echo '<style type="text/css">
    #header-logo { background-image: url(' . get_bloginfo('template_directory') . '/images/login_logo.png) !important; width: 100% !important; background-size: 100% 100% !important;}
    </style>';
}
add_action('admin_head', 'custom_logo');

//修改登录页面LOGO
function custom_login_logo() {
	echo '<style type="text/css">
    h1 a { background-image:url(' . get_bloginfo('template_directory') . '/images/login_logo.png?v=2) !important; width: 100% !important; background-size: 100% 100% !important;}
    </style>';
}
add_action('login_head', 'custom_login_logo');

//隐藏版本更新
add_filter('pre_site_transient_update_core', create_function('$a', "return null;"));

//修改页脚信息
function modify_footer_admin() {
	echo '际泉熙.';
}
add_filter('admin_footer_text', 'modify_footer_admin');

//完整的删除WordPress的版本号
function wpbeginner_remove_version() {
	return '';
}
add_filter('the_generator', 'wpbeginner_remove_version');

//隐藏管理后台帮助按钮和版本更新提示
function hide_help() {
	echo '<style type="text/css">#contextual-help-link-wrap { display: none !important; } .update-nag{ display: none !important; } #footer-left, #footer-upgrade{ display: none !important; }#wp-admin-bar-wp-logo{display: none !important;}.default-header img{width:400px;}</style>';
}
add_action('admin_head', 'hide_help');

//去除header冗余代码
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'wp_generator');

/**
 * 个人信息背景表
 */
function wpdocs_register_my_from() {
	add_menu_page('MyFrom', '个人信息背景表', 'manage_options', 'my-from', 'myFromSettings');
}
function myFromSettings() {
	require get_template_directory() . '/my-plugins/from/from.php';
}
add_action('admin_menu', 'wpdocs_register_my_from');
add_action('wp_ajax_nopriv_my_from_info', 'my_from_info');
add_action('wp_ajax_my_from_info', 'my_from_info');
function my_from_info() {
	global $wpdb, $post;

	var_dump($_POST);
	delete_option('my-from-type-info');

	//若值为空，则删除这行数据
	if (empty($_POST['my-from-info'])) {
		echo 'empty';
		delete_option('my-from-info');
	} else {
		echo 'dadad';
		//若提交了表单，则保存变量
		update_option('my-from-info', $_POST['my-from-info']);
	}
	die;
}

/**
 * 资料下载管理
 */
function wpdocs_register_my_video() {
	add_menu_page('MyVideo', '资料下载管理', 'manage_options', 'my-video', 'myVideoSettings');
}
function myVideoSettings() {
	require get_template_directory() . '/my-plugins/video/video.php';
}
add_action('admin_menu', 'wpdocs_register_my_video');
add_action('wp_ajax_nopriv_my_video_info', 'my_video_info');
add_action('wp_ajax_my_video_info', 'my_video_info');
function my_video_info() {
	global $wpdb, $post;

	var_dump($_POST);
	delete_option('my-video-type-info');

	//若值为空，则删除这行数据
	if (empty($_POST['my-video-info'])) {
		delete_option('my-video-info');
	} else {
		//若提交了表单，则保存变量
		update_option('my-video-info', $_POST['my-video-info']);
	}
	die;
}

/**
 * 媒体链接管理
 */
function wpdocs_register_my_news() {
	add_menu_page('MyNews', '媒体链接管理', 'manage_options', 'my-news', 'myNewsSettings');
}
function myNewsSettings() {
	require get_template_directory() . '/my-plugins/news/news.php';
}
add_action('admin_menu', 'wpdocs_register_my_news');
add_action('wp_ajax_nopriv_my_news_info', 'my_news_info');
add_action('wp_ajax_my_news_info', 'my_news_info');
function my_news_info() {
	global $wpdb, $post;

	var_dump($_POST);
	delete_option('my-news-type-info');

	//若值为空，则删除这行数据
	if (empty($_POST['my-news-info'])) {
		delete_option('my-news-info');
	} else {
		//若提交了表单，则保存变量
		update_option('my-news-info', $_POST['my-news-info']);
	}
	die;
}
