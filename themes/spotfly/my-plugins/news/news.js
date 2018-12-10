var My_Helpers = {
    getDbUrl: location.origin + '/manage/?json=settings/my_news',
    ajaxSubmitUrl: location.origin + "/manage/wp-admin/admin-ajax.php",
    current_db: [],
    current_dom: jQuery('#my-content__wrap'),
    current_popup_dom: jQuery('#my-content__popup'),
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
                var list = response.data || [];
                My_Helpers.current_db = list.sort(Pubilc_Helpers.compare('order'))
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
        return '<li class="con_list_item first_row default_list" data-id="' + team.id + '">' +
                '<div class="list_item_top">' +
                    '<div class="position">' +
                        '<div class="p_top">' +
                            '<a class="position_link">' +
                                '<h3 class="js_name">' + team.name + '</h3>' +
                            '</a>' +
                        '</div>' +
                        '<div class="p_bot">' +
                            '<div class="li_b_l">' +
                                '显示顺序：<span class="js_order">' + (team.order || '默认排序') + '</span>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="list_item_bot">' +
                    '<div class="li_b_l">' +
                        '<a class="my-content__delete-btn">删 除</a>' +
                        '<a class="my-content__update-btn">编 辑</a>' +
                    '</div>' +
                '</div>' +
            '</li>'
    },

    // 获取弹框HTML
    getPopupDom: function(type, item) {
        return '<div class="popup__content">' +
                    '<a class="popup__close">' +
                        '<svg><use xlink:href="#icon-close"></use></svg>' +
                    '</a>' +

                    '<header class="popup__header">' +
                        '<h3>' +
                            '- <span>' + (type === 'create' ? '添加媒体链接' : '更新媒体链接') + '</span> -' +
                        '</h3>' +
                    '</header>' +

                    '<div class="popup__main">' +
                        '<ul class="my-content__popup-ul" data-id="' + item.id + '">' +
                            '<li class="clearfix">' +
                                '<div class="label">' +
                                    '媒体链接名称:' +
                                '</div>' +
                                '<div class="value">' +
                                    '<input class="my-input" type="text" name="name" value="' + item.name + '">' +
                                '</div>' +
                            '</li>' +
                            '<li class="clearfix">' +
                                '<div class="label">' +
                                    '媒体链接地址:' +
                                '</div>' +
                                '<div class="value">' +
                                    '<input class="my-input" type="text" name="link" value="' + item.link + '">' +
                                '</div>' +
                            '</li>' +
                            '<li class="clearfix">' +
                                '<div class="label">' +
                                    '媒体发布日期:' +
                                '</div>' +
                                '<div class="value">' +
                                    '<input class="my-input" type="text" name="date" value="' + item.date + '">' +
                                '</div>' +
                            '</li>' +
                            '<li class="clearfix">' +
                                '<div class="label">' +
                                    '显示顺序:' +
                                '</div>' +
                                '<div class="value">' +
                                    '<input class="my-input" type="number" name="order" value="' + item.order + '">' +
                                '</div>' +
                            '</li>' +
                        '</ul>' +
                    '</div>' +

                    '<footer class="popup__footer">' +
                        '<button type="button" class="my-button btn_left my-content__popup-cancel">' +
                            '<span>取消</span>' +
                        '</button>' +
                        '<button type="button" class="my-button primary btn_right my-content__popup-save">' +
                            '<span>保存</span>' +
                        '</button>' +
                    '</footer>' +
                '</div>'
    },

    // 显示弹框
    showPopup: function() {
        var type = My_Helpers.current_edit_info ? 'update' : 'create';
        var jobData = type === 'create' ? My_Helpers.getBaseData() : My_Helpers.current_edit_info;
        var jobDom = My_Helpers.getPopupDom(type, jobData);
        My_Helpers.current_popup_dom.html(jobDom);
        My_Helpers.current_popup_dom.addClass('showPopup');
    },

    // 关闭弹框
    closePopup: function() {
        My_Helpers.current_edit_info = null;
        My_Helpers.current_popup_dom.removeClass('showPopup');
    },

    // 弹框保存
    savePopup: function() {
        var popupData = My_Helpers.getPopupData();

        if(!popupData) return;
        if(My_Helpers.current_edit_info) {
            var i = 0;
            var max = My_Helpers.current_db.length;
            for(; i < max; i++){
                if(My_Helpers.current_db[i].id === My_Helpers.current_edit_info.id) {
                    My_Helpers.current_db[i] = popupData;
                    break;
                }
            }

            My_Helpers.updateItemDom(popupData);
        } else {
            var jobDom = My_Helpers.getItemDom(popupData);
            My_Helpers.current_dom.prepend(jobDom)
            My_Helpers.current_db.unshift(popupData);
        }
        My_Helpers.formSubmit();
    },

    // 更新列表HTML
    updateItemDom: function(itemData) {
        if(!itemData) return;

        var wrapDom =  My_Helpers.current_dom.find('[data-id="' + itemData.id + '"]');
        for(var key in itemData) {
            var itemDom = wrapDom.find('.js_' + key);
            if(itemDom) {
                itemDom.text(itemData[key]);
            }
        }
    },

    // 获取弹框数据
    getPopupData: function() {
        var data = [];
        var ulDom = My_Helpers.current_popup_dom.find('.my-content__popup-ul');
        var id = ulDom.data('id');
        var name = ulDom.find('input[name=name]').get(0).value;
        var link = ulDom.find('input[name=link]').get(0).value;
        var date = ulDom.find('input[name=date]').get(0).value;
        var order = ulDom.find('input[name=order]').get(0).value;

        if(!name || !link || !date) {
            let tips = [];

            if(!name) tips.push('名字');
            if(!link) tips.push('媒体链接链接地址')
            if(!date) tips.push('媒体链接发布日期')

            alert('请填写完整信息！' + tips.join('、') + '不能为空！')
            return false;
        }

        return {
            id: id,
            name: name,
            link: link,
            date: date,
            order: order,
        };
    },


    // 添加
    add: function() {
        My_Helpers.current_edit_info = null;
        My_Helpers.showPopup();
    },

    // 更新
    update: function(jobId) {
        var job = null;
        for (var i = My_Helpers.current_db.length - 1; i >= 0; i--) {
            if(My_Helpers.current_db[i].id === jobId) {
                job = My_Helpers.current_db[i];
                break;
            }
        }

        if(job) {
            My_Helpers.current_edit_info = job;
            My_Helpers.showPopup();
        } else {
            alert('当前信息有误！请删除!')
        }
    },

    // 删除
    delete: function(jobId) {
        var teamDom = jQuery('li[data-id="' + jobId + '"]')
        console.log(teamDom)
        if(teamDom) {
            teamDom.remove();
            for (var i = My_Helpers.current_db.length - 1; i >= 0; i--) {
                if(My_Helpers.current_db[i].id === jobId) {
                    job = My_Helpers.current_db[i];
                    My_Helpers.current_db.splice(i, 1);
                    break;
                }
            }
            My_Helpers.formSubmit();
        }
    },

    // 获取单条默认信息
    getBaseData: function() {
        return {
            id: Pubilc_Helpers.uuid(),
            name: '',
            link: '',
            date: '',
            order: (My_Helpers.current_db.length + 1) * 10
        }
    },

    //表单提交
    formSubmit: function() {
        var ajax_data = {   
            action: "my_news_info",   
            'my-news-info': My_Helpers.current_db
        };

        console.log(ajax_data);
        jQuery.ajax({
            url: My_Helpers.ajaxSubmitUrl,
            data: ajax_data,
            type: 'POST',
            beforeSend: function() {
                Pubilc_Helpers.loading('my-content__popup', true);
            },
            complete: function() {
                Pubilc_Helpers.loading('my-content__popup', false);
            },
            error: function(response) {
                alert('保存错误，请刷新重试！')
                console.log(response)
            },
            success: function(response) {
                console.log(response);
                alert('保存成功！')
                Pubilc_Helpers.loading('my-content__popup', false);
                My_Helpers.closePopup();
            }
        })
    },
}


jQuery(function($) {

    // 模块数据初始化
    My_Helpers.getDb();
    

    /**
     * 添加
     */
    $('#my-content').on('click', '.my-content__add', function(event) {
        event.preventDefault();
        My_Helpers.add();
    })

    /**
     * 更新
     */
    My_Helpers.current_dom.on('click', '.my-content__update-btn', function(event) {
        event.preventDefault();
        var jobId = $(event.target).parents('li.con_list_item').data('id');
        My_Helpers.update(jobId);
    })

    /**
     * 删除
     */
    My_Helpers.current_dom.on('click', '.my-content__delete-btn', function(event) {
        event.preventDefault();
        var itemId = $(event.target).parents('li.con_list_item').data('id');
        Pubilc_Helpers.dispConfirm('确认删除当前信息？', function() {
            My_Helpers.delete(itemId)
        });
    })

    /**
     * 弹框关闭
     */
    My_Helpers.current_popup_dom.on('click', '.my-content__popup-cancel, .popup__close', function(event) {
        event.preventDefault();
        My_Helpers.closePopup();
    })

    /**
     * 弹框保存
     */
    My_Helpers.current_popup_dom.on('click', '.my-content__popup-save', function(event) {
        event.preventDefault();
        My_Helpers.savePopup();
    })
})