(function ($) {
    var InspectionMap = window.InspectionMap || {};
    function _load(o) {
        o = $.extend({}, {holder: '.inspection-hospital-map-form'}, o);
        $('#inspection-right section').mask();
        $.ajax({
            data: o.data,
            url: o.action,
            success: function (html) {
                $('#inspection-right section').unmask();
                if (typeof(o.cb) === 'function')
                    if(!o.cb(html)) {
                        return;
                    }
                if (o.getrid) {
                    for (var k in o.getrid) {
                        html = html.replace(o.getrid[k], '');
                    }
                }
                $('#inspection-right .panel-body').html(html);
                if ($('#btn_submit').length)
                    $('#btn_submit').click(function () {
                        $('#inspection-right section').mask();
                        $.ajax({
                            data: $('.inspection-form form').serialize(),
                            url: o.action,
                            type: 'POST',
                            success: function (html) {
                                $('#inspection-right .panel-body').html($('table.detail-view', $(html)));
                                //refreshNode(o.action === 'create' ? o.src : o.src.parents('li:eq(0)'));
                                $('#inspection-right section').unmask();
                            }
                        });
                        return false;
                    });
            }
        });
    }
    function refreshNode(node) {
        var dom = $(node);
        dom.find('.tree-branch-children').empty();
        $('#tree').tree('openFolder', dom);
    }

    InspectionMap.view = function (src, id) {
        _load({
            src: src,
            action: 'view',
            data: {id: id},
            holder: 'table.detail-view'
        });
    }
    InspectionMap.create = function (src, id) {
        _load({
            src: src,
            action: 'create',
            data: {parent_id: id}
        });
    }
    InspectionMap.update = function (src, id, cb) {
        _load({
            src: src,
            action: '/inspection/hospital/update?hosp_id=' + InspectionMap.hospitalId + '&insp_id=' + id,
            cb: cb,
            getrid: [/\<link.*?bootstrap\.css.*?\>/, /\<script.*?jquery\.js.*?\>/]
        });
    }
    InspectionMap.del = function (src, id, cb) {
        _load({
            src: src,
            action: '/inspection/hospital/update?hosp_id=' + InspectionMap.hospitalId + '&insp_id=' + id,
            cb: cb
        });
    }

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
                    url: '/inspection/hospital/search?hosp_id=' + InspectionMap.hospitalId,
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
            itemSelect: false,
            disclosuresUpperLimit: 1,
            cacheItems: true
        });
        $('#tree').tree('discloseAll');
        $('#tree').on('loaded.fu.tree', function (e, p) {
            initTreeActions();
        });

        $(document).on('click', '.fa-plus', function () {
            var item = $(this).parents('li:eq(0)'),
                itemid = item.attr('id'),
                id = itemid.split('-')[3];

            InspectionMap.create(item, id);

        });
        $(document).on('click', '.fa-pencil', function () {
            var item = $(this).parents('li:eq(0)'),
                itemid = item.attr('id'),
                id = itemid.split('-')[3];

            InspectionMap.update(item, id);
        });
        $(document).on('click', '.fa-trash-o', function () {
            var item = $(this).parents('li:eq(0)'),
                itemid = item.attr('id'),
                id = itemid.split('-')[3];

            InspectionMap.del(item, id);
        });
        $(document).on('click', '.tree-item-name', function (e) {
            var src = $(e.srcElement ? e.srcElement : e.target);
            if (src.hasClass('icon-caret'))
                return;
            var item = $(this).parents('li:eq(0)'),
                itemid = item.attr('id'),
                id = itemid.split('-')[3];
            if (id > 0) {
                if (item.attr('selected') && src.hasClass('item-check')) {
                    if (confirm('确定要移出此项?'))
                        InspectionMap.del(item, id, function () {
                            return item.removeAttr('selected');
                        });
                } else {
                    InspectionMap.update(item, id, function () {
                        return item.attr('selected', 'selected');
                    });
                }
            }
        });

    }
    function pageInit() {
        eventBind();
    }
    $(pageInit);
})(jQuery);