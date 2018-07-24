/**
 * Created by TF on 2018/1/15.
 */
var len = $("img[modal='zoomImg']").length;
var arrPic = new Array(); //定义一个数组
for (var i = 0; i < len; i++) {
    arrPic[i] = $("img[modal='zoomImg']").eq(i).prop("src"); //将所有img路径存储到数组中
}

$("img[modal='zoomImg']").each(function () {
    $(this).on("click", function () {
        //给body添加弹出层的html
        $("body").append("<div class=\"mask-layer\">" +
            "   <div class=\"mask-layer-black\"></div>" +
            "   <div class=\"mask-layer-container\">" +
          
            "       <div class=\"mask-layer-imgbox auto-img-center\"></div>" +
            "   </div>" +
            "</div>"
        );

        var img_index = $("img[modal='zoomImg']").index(this);//获取点击的索引值
        var num = img_index;

        function showImg() {
            $(".mask-layer-imgbox").append("<p><img src=\"\" alt=\"\"></p>");
            $(".mask-layer-imgbox img").prop("src", arrPic[num]); //给弹出框的Img赋值

            //图片居中显示
            var box_width = $(".auto-img-center").width(); //图片盒子宽度
            var box_height = $(".auto-img-center").height();//图片高度高度
            var initial_width = $(".auto-img-center img").width();//初始图片宽度
            var initial_height = $(".auto-img-center img").height();//初始图片高度
            if (initial_width > initial_height) {
                $(".auto-img-center img").css("width", box_width);
                var last_imgHeight = $(".auto-img-center img").height();
                $(".auto-img-center img").css("margin-top", -(last_imgHeight - box_height) / 2);
            } else {
                $(".auto-img-center img").css("height", box_height);
                var last_imgWidth = $(".auto-img-center img").width();
                $(".auto-img-center img").css("margin-left", -(last_imgWidth - box_width) / 2);
            }
            //关闭按钮
            $(".mask-close").click(function () {
                $(".mask-layer").remove();
            });
            $(".mask-layer-black").click(function () {
                $(".mask-layer").remove();
            });
        }
        showImg();
    })
});