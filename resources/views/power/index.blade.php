<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui/css/H-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/css/H-ui.admin.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/lib/Hui-iconfont/1.0.8/iconfont.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/skin/default/skin.css') }}" id="skin" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/page.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/boxImg.css') }}">
    <script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/jquery/1.9.1/jquery.min.js') }}"></script>
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!--/meta 作为公共模版分离出去-->

    <title>权限 - 权限管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>

@if (Session::has('edit_status'))
<script type="text/javascript">
    $(function(){
        layer.alert("{{ Session::get('edit_status') }}", {icon: 1});
    });
</script>
@endif

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 权限列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <input type="text" name="" id="activity_name" value="" placeholder=" 活动名称" style="width:250px" class="input-text">
        <button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜权限节点</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="power_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加权限节点" data-href="/power_add" id="activity_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加权限节点</a>
        </span>
    <div class="mt-20">
        <table></table>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('/js/boxImg.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>
<script type="text/javascript">
    $(function(){
        // /*活动-添加*/
        // $('#activity_add').bind("click",function(){
        //     var index = layer.open({
        //         type: 2,
        //         title: '添加活动',
        //         content: '/activity_add'
        //     });
        //     layer.full(index);
        // });
        //
        // /*活动-多条删除*/
        // $('#activity_delall').bind("click",function(){
        //     var ids = '';
        //     $(".ckb").each(function () {
        //         if ($(this).is(':checked')) {
        //             ids += ',' + $(this).val(); //逐个获取id
        //         }
        //     });
        //     var ids = ids.substring(1);
        //     var url = '/activity_del';
        //     var data = {'id':ids};
        //     layer.open({
        //         content: '确认要删除？'
        //         ,btn: ['是的', '算了']
        //         ,yes: function(index, layero){
        //             $.post(url, data, function(xhr){
        //                 layer.confirm(xhr.res_desc, {
        //                     btn: ['好的'] //可以无限个按钮
        //                     ,yes: function(index, layero){
        //                         window.location.reload();
        //                     }
        //                 });
        //             });
        //         }
        //         ,btn2: function(index, layero){
        //             //return false 开启该代码可禁止点击该按钮关闭
        //         }
        //         ,cancel: function(){
        //             //return false 开启该代码可禁止点击该按钮关闭
        //         }
        //     });
        // });
        //
        // /*活动-删除*/
        // $(".activity_del").bind("click",function(){
        //     var id = $(this).attr('data-id');
        //     var url = '/activity_del';
        //     var data = {'id':id};
        //     layer.open({
        //         content: '确认要删除？'
        //         ,btn: ['是的', '算了']
        //         ,yes: function(index, layero){
        //             $.post(url, data, function(xhr){
        //                 layer.confirm(xhr.res_desc, {
        //                     btn: ['好的'] //可以无限个按钮
        //                     ,yes: function(index, layero){
        //                         window.location.reload();
        //                     }
        //                 });
        //             });
        //         }
        //         ,btn2: function(index, layero){
        //             //return false 开启该代码可禁止点击该按钮关闭
        //         }
        //         ,cancel: function(){
        //             //return false 开启该代码可禁止点击该按钮关闭
        //         }
        //     });
        // });
        //
        // /*活动-修改*/
        // $('.activity_edit').bind("click",function(){
        //     var index = layer.open({
        //         type: 2,
        //         title: '修改活动',
        //         content: '/activity_edit'+'?id='+$(this).attr('data-id')
        //     });
        //     layer.full(index);
        // });
        //
        // /*活动-查看内容*/
        // $('#activity_show').bind("click", function(){
        //     var index = layer.open({
        //         type: 2,
        //         title: '活动内容',
        //         content: '/activity_show'+'?id='+$(this).attr('data-id')
        //     });
        //     layer.full(index);
        // });
        //
        // /*活动-搜索*/
        // $('#btn-search').bind("click", function(){
        //     var name = $('#activity_name').val();
        //     window.location.href = '/activity?activity_name=' + name;
        // });
    })
</script>
</body>
</html>