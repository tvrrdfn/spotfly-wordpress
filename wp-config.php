<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', 'bdm304887567_db');

/** MySQL数据库用户名 */
define('DB_USER', 'bdm304887567');

/** MySQL数据库密码 */
define('DB_PASSWORD', 'Poxiaohuiheng1');

/** MySQL主机 */
define('DB_HOST', 'bdm304887567.my3w.com');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/** secret key */
define('JWT_AUTH_SECRET_KEY', '[&r5o3qE!u+C0z)/C650T-~`1Xnl+T_TWdZ||l(m0(+^@t!WS4=bN/7|Iek-0*(v');

/** 激活CORS选项  */
define('JWT_AUTH_CORS_ENABLE', true);

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'V?xyUcnWA2Y]xa pJGotn<DCh2tjcf+*zD7-TB1ShGVhn1.Pp G,>/7<w{BzxGc=');
define('SECURE_AUTH_KEY', 'e_f@$c$UX:nA/l^w<,e9NstcNLR7~ch^+(#|rz[I}7Tz}ycZ>{.KLfhGzvCW]tKq');
define('LOGGED_IN_KEY', '0@ h2aZ[2g,*bF2rEh_,M>;~4UzD^Ql2oZo?$-3>VM#dEdqo|RaCo(3mfrCBoZ7m');
define('NONCE_KEY', '5k%%Lw#n)?!FVDB..68|v#Ij}-o%Yfr%K8b~qJm|s`qd.=v!`4%7ksBUs$iV`X<g');
define('AUTH_SALT', '_*@.9Y(SesUMD:VOgYj~Ee1 b*6I:_zh~2$2ROYi&*>8u_it?[u@(%<oKg-cDtfj');
define('SECURE_AUTH_SALT', 'yD:UXjPC5;:~Kr5H(Z|UQ*$LLI$C%V3&tcw5+v ^FkVDg/(rT<lrbgy@u>5?;kq?');
define('LOGGED_IN_SALT', ']H&HTsmHR8k0K`*s7z%d1J)MvI<v9sUU$h $88A1_BT7T4n)H;{{YJ)N;1%OHwhC');
define('NONCE_SALT', 'NnYY$1bi{RK,ip1b)?y=y_$-DBcBPLS|c_X:oXRxF6/;>=s,H_? R]Rnc46r{9/6');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix = 'sf_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if (!defined('ABSPATH')) {
	define('ABSPATH', dirname(__FILE__) . '/');
}

/** 设置WordPress变量和包含文件。 */
require_once ABSPATH . 'wp-settings.php';
