<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="{{ asset('/resources/views/admin/style/css/ch-ui.admin.css') }}">
    <link rel="stylesheet" href="{{ asset('/resources/views/admin/style/font/css/font-awesome.min.css') }}">
    <script type="text/javascript" src="{{ asset('/resources/views/admin/style/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/resources/views/admin/style/js/ch-ui.admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/resources/org/layer/layer.js') }}"></script>
<style>
    .select2-container {
        box-sizing: border-box !important ;
        margin: 0 !important;
        position: relative;
        display: inline !important;
        vertical-align: middle !important;
    }
    table.add_tab tr td span{
        margin-left: 0px !important;
    }
    table.add_tab tr {
        line-height: 30px !important;
    }
    </style>
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
</head>
<body>
@yield('content')

{{--<div class="result_wrap">--}}
{{--<div class="result_title">--}}
{{--<h3>使用帮助</h3>--}}
{{--</div>--}}
{{--<div class="result_content">--}}
{{--<ul>--}}
{{--<li>--}}
{{--<label>官方交流网站：</label><span><a href="#">http://bbs.houdunwang.com</a></span>--}}
{{--</li>--}}
{{--<li>--}}
{{--<label>官方交流QQ群：</label><span><a href="#"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png"></a></span>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
<!--结果集列表组件 结束-->

</body>
</html>