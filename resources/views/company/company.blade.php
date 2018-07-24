<?php
date_default_timezone_set('PRC');
$time = time()+(8*60*60)-170;
$date = date('Y-m-d H:i:s', $time);
?>
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

    <title>活动管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
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

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 活动管理 <span class="c-gray en">&gt;</span> 活动列表 <a class="btn btn-success radius r" id="btn-success" style="line-height:1.6em;margin-top:3px" href="javascript:void(0)" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <span class="select-box inline">
        <select name="company_type" class="select" id="company_type">
            <option value="">全部类型</option>
            @foreach($company_type as $val)
                <option value="{{ $val->ct_id }}" <?php if($type == $val->ct_id){ echo "selected=selected"; } ?>>{{ $val->ct_type }}</option>
            @endforeach
        </select>
		</span>
        <input type="text" name="" id="company_name" value="{{ $company_name }}" placeholder=" 公司名称" style="width:250px" class="input-text">
        <button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜公司</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="company_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加活动" data-href="/company_add" id="company_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加公司</a>
        </span>
        <span class="r c-red">注：首页只取此排序的顺序，显示前六条公司</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr class="text-c" role="row">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">公司名称</th>
                <th width="80">公司简介</th>
                <th width="80">运营模式</th>
                <th width="80">运营人数</th>
                <th width="120">牌照类型</th>
                <th width="120">成立时间</th>
                <th width="120">评分</th>
                <th width="120">公司图片</th>
                <th width="75">返水</th>
                <th width="75">是否认证</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($company_info as $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{ $val->c_id }}" class="ckb"></td>
                    <td>{{ $val->c_id }}</td>
                    <td>{{ $val->c_name }}</td>
                    <td>{{ $val->c_introduction }}</td>
                    <td>{{ $val->c_business_type }}</td>
                    <td>{{ $val->c_operatings }}</td>
                    <td>{{ $val->c_license_type }}</td>
                    <td>{{ $val->c_foundationtime }}</td>
                    <td>{{ $val->c_scores }}</td>
                    <td><img src="{{ URL::asset( $val->c_image163x92 ) }}" modal="zoomImg" width="100px" height="70px" id="img"/></td>
                    <td>{{ $val->c_returns }}</td>
                    <td>
                        @if($val->c_certified == 1)
                            是
                        @else
                            否
                        @endif
                    </td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" class="ml-5 company_edit" data-id="{{ $val->c_id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 company_del" data-id="{{ $val->c_id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-c">
                    <td colspan="20">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $company_info->appends(request()->all())->links() }}
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

        // 添加
        $('#company_add').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '添加公司',
                content: '/company_add'
            });
            layer.full(index);
        });

        // 多条删除
        $('#company_delall').bind("click",function(){
            var ids = '';
            $(".ckb").each(function () {
                if ($(this).is(':checked')) {
                    ids += ',' + $(this).val(); //逐个获取id
                }
            });
            var ids = ids.substring(1);
            var url = '/company_del';
            var data = {'id':ids};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.href='/company';
                            }
                        });
                    });
                }
            });
        });

        // 删除
        $(".company_del").bind("click",function(){
            var id = $(this).attr('data-id');
            var url = '/company_del';
            var data = {'id':id};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.href='/company';
                            }
                        });
                    });
                }
            });
        });

        // 修改
        $('.company_edit').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '修改活动',
                content: '/company_edit'+'?id='+$(this).attr('data-id')
            });
            layer.full(index);
        });

        // 搜索
        $('#btn-search').bind("click", function(){
            var name = $('#company_name').val();
            var type = $('#company_type').val();
            window.location.href = '/company_search?company_name=' + name + '&company_type=' + type;
        });
    })
</script>
</body>
</html>