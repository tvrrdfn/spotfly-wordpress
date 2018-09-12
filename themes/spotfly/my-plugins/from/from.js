var My_Helpers = {
    getDbUrl: location.origin + '/manage/?json=settings/my_from',
    current_db: [],
    current_dom: jQuery('#my-content__wrap'),
    current_edit_info: null, //当前编辑的信息


    // 获取列表
    getDb: function() {
        jQuery.ajax({
            url: My_Helpers.getDbUrl,
            type: 'GET',
            beforeSend: function() {
                Pubilc_Helpers.loading('my-content', true);
            },
            complete: function() {
                Pubilc_Helpers.loading('my-content', false);
            },
            error: function(response) {
                console.log(response)
            },
            success: function(response) {
                console.log(response);
                Pubilc_Helpers.loading('my-content', false);
                My_Helpers.current_db = response.data || [];
                My_Helpers.initDom();
            }
        })
    },

    // 初始化   
    initDom: function() {
        var dom = '';
        var i = 0;
        var max = My_Helpers.current_db.length;
        var html = '';

        for (; i < max; i++) {
            let team = My_Helpers.current_db[i];
            dom += My_Helpers.getItemDom(team);
        }
        My_Helpers.current_dom.html(dom);
    },

    // 获取单条信息HTML
    getItemDom: function(team) {
        return '<li class="con_list_item first_row default_list">' +
                '<div class="item"><div class="title">提交时间:</div><div class="content">' + (team.time || '') + '</div></div>' +
                '<div class="item"><div class="title">姓名:</div><div class="content">' + team.name + '</div></div>' +
                '<div class="item"><div class="title">手机:</div><div class="content">' + team.phone + '</div></div>' +
                '<div class="item"><div class="title">电子邮箱:</div><div class="content">' + team.email + '</div></div>' +
                '<div class="item"><div class="title">投资经验:</div><div class="content">' + team.term.name + '</div></div>' +
                '<div class="item"><div class="title">资金量区间:</div><div class="content">' + team.fund.name + '</div></div>' +
                '<div class="item"><div class="title">年龄范围:</div><div class="content">' + team.old.name + '</div></div>' +
            '</li>'
    },
}


jQuery(function($) {

    // 模块数据初始化
    My_Helpers.getDb();
})