@extends('words.app')

@section('title', 'boom')

@section('script')
    @parent <!--这条用于加上原有的内容-->
	
$(document).ready(function(){
  $("button#put").click(function(){
	var txt=$("#words").val();
	txt=txt.replace(/\n/g,";");
    $.post("/trans.php",
    {
      data:txt,
      date:$("#date").val(),
    },
    function(data,status){
      alert("数据：" + data + "\n状态：" + status);
    });
  });
});

@endsection

@section('body')
    
<textarea id="words"></textarea><br />
<input type="text" id='date' value="{{date("Ymd")}}"><br />
<button id="put">submit</button>
</form>
<br>
@foreach ($results as $result)
<a href="detail.php?type=1&id={{$result->date}}">{{$result->date}}</a>:{{$result->count}}<br>
@endforeach
@endsection
