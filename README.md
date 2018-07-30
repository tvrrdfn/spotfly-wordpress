### 文件说明
1. plugins文件夹是在 wordpress/wp-content/plugins/json-api
2. themes文件夹目录：wordpress/wp-content/themes/futurecap

### 安装说明
1. 安装插件JSON API
2. 安装插件JWT Authentication for WP-API(安装此插件，必须设置固定连接为非朴素型才可以打开接口)
3. 将模板文件导入并使用

### wordpress安装在子目录下
1. 修改wp-config.php文件，添加
```
/** 后台地址转向 */
define('WP_SITEURL', 'http://www.weizehao.com/admin');
```
2. wp-config.php文件，添加
```
/** secret key */
define('JWT_AUTH_SECRET_KEY', '[&r5o3qE!u+C0z)/C650T-~`1Xnl+T_TWdZ||l(m0(+^@t!WS4=bN/7|Iek-0*(v');

/** 激活CORS选项  */
define('JWT_AUTH_CORS_ENABLE', true);
```

### 前台调用
1. post请求需要先获取token：
```
{
    name: 'getToken',
    method: 'post',
    url: '/wp-json/jwt-auth/v1/token'
}

WpApi.getToken({
    username: 'admin',
    password: 'admin123!@#'
})
```
2. 再提交数据:
```
let url = '/api/wp-admin/admin-ajax.php'
let data = {   
    action: "my_from_info",  //插件JSON API对应的接口
    'my-from-info': [...this.fromList, sendData] //真正数据
}
jQuery.ajax({
    url: url,
    data: data,
    type: 'POST',
    headers: {
        'Authorization': 'Bearer ' + token
    },
    beforeSend: function() {
        console.log('beforeSend')
    },
    complete: function() {
        console.log('complete')
    },
    error: function(response) {
        alert('保存错误，请刷新重试！')
        _self.isLoading = false
    },
    success: function(response) {
        alert('保存成功！')
        _self.clearData()
    }
})
```

### JWT Authentication for WP-API 插件说明
1. 插件API地址：https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/
2. 注意事项：必须设置固定连接为非朴素型才可以打开接口、.htaccess文件可以不用设置。

### JSON API 插件说明
1. 在controllers文件夹中添加php文件即可，添加接口后，需要在后台中点击【启用】



