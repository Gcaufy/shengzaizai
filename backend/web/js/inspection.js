(function ($) {
    function initTreeActions() {
        $('.tree-label').each(function (i) {
            var item = $(this).parents('li').eq(0), id = 0, level = '00';
            if (!item[0].id)
                return;
            level = item[0].id.split('-')[2];
            if (level == '00') {
                item.find('.tree-actions').eq(0).find('.fa-pencil, .fa-trash-o').remove();
            } else if (level > 0) {
                item.find('.tree-actions').eq(0).find('.fa-plus').remove();
            }
        });
    }

    function eventBind() {
        $('#tree').tree({
            dataSource: function (parentData, callback) {
                var data = {}, id;
                if (!parentData.name) {
                    callback({data: [{name: '所有检查项', type: 'folder', dataAttributes: {id: 'tree-id-00-0'}}]});
                    initTreeActions();
                    return;
                }
                if (parentData.dataAttributes.id != 'tree-id-0') {
                    id = parentData.dataAttributes.id.split('-')[3];
                    data['id'] = id;
                }
                $.ajax({
                    url: '/inspection/inspection/search',
                    data: data,
                    dataType: 'json',
                    success: function (d) {
                        callback({data: d});
                    }
                });
                return;
            },
            //multiSelect: true,
            //folderSelect: true,
            disclosuresUpperLimit: 1,
            cacheItems: true
        });
        $('#tree').tree('discloseAll');
        $('#tree').on('loaded.fu.tree', function (d) {
            initTreeActions();
        });

        $(document).on('click', '.fa-plus', function () {
            var item = $(this).parents('li:eq(0)'),
                itemid = item.attr('id'),
                id = itemid.split('-')[3];
            $.ajax({
                data: {parent_id: id},
                url: 'create',
                success: function (html) {
                    $('#inspection-right .panel-body').html($('.inspection-form', $(html)));
                    $('#btn_submit').click(function () {
                        $.ajax({
                            data: $('.inspection-form form').serialize(),
                            url: 'create',
                            type: 'POST',
                            success: function (html) {
                                $('#inspection-right .panel-body').html($('table.detail-view', $(html)));
                            }
                        });
                        return false;
                    });
                }
            });

        });
        $(document).on('click', '.fa-pencil', function () {
            var item = $(this).parents('li:eq(0)'),
                itemid = item.attr('id'),
                id = itemid.split('-')[3];
        });
        $(document).on('click', '.fa-trash-o', function () {
            var item = $(this).parents('li:eq(0)'),
                itemid = item.attr('id'),
                id = itemid.split('-')[3];
        });
    }
    function pageInit() {
        eventBind();
    }
    $(pageInit);
})(jQuery);