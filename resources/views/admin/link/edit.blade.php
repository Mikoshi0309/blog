@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo;友情链接
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    @else
                        <p>{{ $errors }}</p>
                    @endif
                </div>
            @endif


        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/link/create')}}"><i class="fa fa-plus"></i>新增连接</a>
                <a href="{{ url('admin/link')}}"><i class="fa fa-recycle"></i>全部连接</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{ url('admin/link/'.$file->link_id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table class="add_tab">
                <tbody>

                <tr>
                    <th><i class="require">*</i>连接名称：</th>
                    <td>
                        <input type="text" name="link_name" value="{{ $file->link_name }}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>连接名称必须填写</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>URL：</th>
                    <td>
                        <input type="text" class="lg" name="link_url" value="{{ $file->link_url }}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>连接标题：</th>
                    <td>
                        <input type="text" class="lg" name="link_title" value="{{ $file->link_title }}">
                    </td>
                </tr>

                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" class="sm" name="link_order" value="{{ $file->link_order }}">

                    </td>
                </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection