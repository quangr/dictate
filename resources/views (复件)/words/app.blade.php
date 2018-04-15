<!DOCTYPE HTML>
<head>
<!--all view will extents this file-->
 <title>@yield('title')</title> <!--定义变量有两种方法yield和下面的section,区别是section和show中间可以加代码，yield是完全替代。-->
<style> 
a{ text-decoration:none} 
</style> 
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
@section('script')
@show
</script> 
</head>
<html>
<body>
@yield('body')
</body>

