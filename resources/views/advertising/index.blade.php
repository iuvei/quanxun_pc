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

    <title>广告管理 - H-ui.admin v3.1</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>

@if (Session::has('edit_status'))
    <script type="text/javascript">
        $(function(){
            layer.open({
                content: "{{ Session::get('edit_status') }}",
                yes: function(index, layero){
                    parent.$( "#btn-success" ).trigger( "click" );
                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                    parent.$(".layui-layer-shade").remove();
                    parent.$(".layui-layer-iframe").remove();
                }
            });
        });
    </script>
@endif

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 广告管理 <span class="c-gray en">&gt;</span> 广告列表 <a class="btn btn-success radius r" id="btn-success" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="advertising_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加活动" data-href="/activity_add" id="activity_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加广告</a>
        </span>
        <span class="r c-red">注：前台只会显示使用前两条来进行展示</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">所属公司</th>
                <th width="80">广告图片</th>
                <th width="80">广告链接</th>
                <th width="120">开始时间</th>
                <th width="120">结束时间</th>
                <th width="60">发布状态</th>
                <th width="60">权重</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($advertising_info as $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{ $val->ad_id }}" class="ckb"></td>
                    <td>{{ $val->ad_id  }}</td></td>
                    <td>{{ $val->c_name }}</td>
                    <td><img src="{{ URL::asset( $val->ad_image479x70 ) }}" modal="zoomImg" width="400px" height="70px" id="img"/></td>
                    <td>{{ $val->ad_url }}</td>
                    <td>{{ $val->ad_starttime }}</td>
                    <td>{{ $val->ad_endtime }}</td>
                    <td class="td-status">
                        @if($val->ad_status == 1)
                            <span class="label label-success radius">已发布</span>
                        @else
                            <span class="label label-error radius">未发布</span>
                        @endif
                    </td>
                    <td>{{ $val->ad_weight }}</td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" class="ml-5 advertising_edit" data-id="{{ $val->ad_id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 advertising_del" data-id="{{ $val->ad_id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-c">
                    <td colspan="20">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $advertising_info->appends(request()->all())->links() }}
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('/js/boxImg.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $('#btn-success').click(function(){
            window.location.reload();
        });

        /*广告-添加*/
        $('#activity_add').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '添加广告',
                content: 'advertising_add'
            });
            layer.full(index);
        });

        // 广告-多条删除
        $('#advertising_delall').bind("click",function(){
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero) {
                    var ids = '';
                    $(".ckb").each(function () {
                        if ($(this).is(':checked')) {
                            ids += ',' + $(this).val(); //逐个获取id
                        }
                    });
                    var ids = ids.substring(1);
                    var url = '/advertising_del';
                    var data = {'id': ids};
                    $.post(url, data, function (xhr) {
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.href='/advertising';
                            }
                        });
                    });
                }
            });
        });

        // 广告-删除
        $(".advertising_del").bind("click",function(){
            var id = $(this).attr('data-id');
            var url = '/advertising_del';
            var data = {'id':id};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.href='/advertising';
                            }
                        });
                    });
                }
            });
        });

        // 广告-修改
        $('.advertising_edit').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '修改活动',
                content: '/advertising_edit'+'?id='+$(this).attr('data-id')
            });
            layer.full(index);
        });
    })
</script>
</body>
</html>