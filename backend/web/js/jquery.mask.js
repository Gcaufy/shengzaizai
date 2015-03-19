(function($){
    $.fn.extend({
        /**
         * 打开遮罩，并显示一段文字。
         * @param  {String} msg    [显示的文字]
         * @param  {String} imgsrc [图片的位置]
         * @return {void}
         */
        mask: function(msg, imgsrc){
            // var loadDiv=$("body").find("._mask_loadDiv");
            var loadDiv = $('body').find("._mask_loadDiv"),
                contentDiv = $('body').find('._mask_content');
            msg = msg || '数据加载中...';
            imgsrc = imgsrc || '/img/loading.gif';
            if (!loadDiv.length){    // add Mask
                loadDiv = $("<div class='_mask_loadDiv' style='display:none;position:absolute; z-index:99998;background-color: #ccc;opacity: 0.3;'></div>");
                contentDiv = $("<div class='_mask_content' style='display:none;position:absolute; z-index:99999;text-align:center; padding:10px; background:#FFF; border:1px solid #ACE' >");
                $("body").append(loadDiv);
                $("body").append(contentDiv);
                var fontsize = 12;
                //loadDiv的宽度= msg的宽度+img的宽度
                var loadDiv_width = msg.length * 2 * fontsize, loadDiv_height = contentDiv.height(), offset = this.offset(), width = this.width(), height = this.height();
                contentDiv.css("width", loadDiv_width);
                loadDiv.css("width", width);
                loadDiv.css("height", height);
                loadDiv.css("top", offset.top);
                loadDiv.css("left", offset.left);
                contentDiv.css("top", offset.top + (height - loadDiv_height) / 2);
                contentDiv.css("left", offset.left + (width - loadDiv_width) / 2);
                if(imgsrc){
                    contentDiv.append("<img src='" + imgsrc + "' alt='" + msg + "' style='width:16px; height:16px'>")
                            .append("<span style='font-size:" + fontsize + "px; margin-left:8px; vertical-align:text-top'>" + msg + "</span>");
                }
            }
            loadDiv.show();
            contentDiv.show();
            return this;
        },
        unmask: function(){
            $('body').find("._mask_loadDiv, ._mask_content").hide();
            return this;
        }
    });
})(jQuery);