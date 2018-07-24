<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="Bookmark" href="favicon.ico">
    <link rel="Shortcut Icon" href="favicon.ico"/>·
    <link rel="stylesheet" href="{{ URL::asset('/Huiadmin/static/h-ui/css/H-ui.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/css/H-ui.admin.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/Huiadmin/lib/Hui-iconfont/1.0.8/iconfont.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/skin/default/skin.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/css/style.css') }}">
    <script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/jquery/1.9.1/jquery.min.js') }}"></script>
    <title>@yield('title')</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"><a class="logo navbar-logo f-l mr-10 hidden-xs" href="/">全讯管理端</a>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>管理员</li>
                    <li class="dropDown dropDown_hover"><a href="#" class="dropDown_A"><?php echo Auth::user()->name; ?><i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="/loginout">退出</a></li>
                        </ul>
                    </li>
                    <li id="Hui-msg"><a href="#" title="消息"><span class="badge badge-danger">1</span><i
                                    class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a></li>
                    <li id="Hui-skin" class="dropDown right dropDown_hover">
                        <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        @foreach($power_finfo as $value)
            <dl id="menu-article">
                <dt><i class="Hui-iconfont">&#xe616;</i> {{ $value->p_name }}<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
                <dd>
                    <ul>
                        @foreach($power_cinfo as $val)
                            @if($value->p_id == $val->f_id)
                                <li><a data-href="{{ $val->p_url }}" data-title="{{ $val->p_name }}" href="javascript:void(0)">{{ $val->p_name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </dd>
            </dl>
        @endforeach
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a>
</div>

<!-- 公共头部代码 -->

@yield('content')

<!-- 公共尾部代码 -->
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $("#menu-article li").each(function () {
            if ($(this).children('a').attr('href') == String(window.location.pathname)){
                $(this).parent().parent().parent().addClass('selected');
                $(this).parent().parent().show();
                $(this).addClass('current');
            }
        });
        $("#article-admin li").each(function () {
            if ($(this).children('a').attr('href') == String(window.location.pathname)){
                $(this).parent().parent().parent().addClass('selected');
                $(this).parent().parent().show();
                $(this).addClass('current');
            }
        });
    });
</script>
</body>
</html>