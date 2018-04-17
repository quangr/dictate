@extends('words.app')

@section('title', 'boom')

@section('script')
    @parent <!--这条用于加上原有的内容-->
	

$(document).ready(function(){
  $("button#put").click(function(){
    var list=[];
    $("input:checked").each(function() {
    list.push($(this).attr("id"));
  });
    wordjson=JSON.stringify(list)
    $.post("/generate",
    {
      data:wordjson,
    },
    function(data,status){
      var a=JSON.parse(data);
      for (key in a){          
          var $audio=$("<audio ></audio>");
          $audio.attr("src",a[key]);
          $audio.attr("controls","controls");
          $("body").append($audio);
}
      alert("成功了,你们看左下角权威认证!");
    });
  });
});

@endsection

@section('body')
@isset($results)
@foreach ($results as $result)
<a href="/user/wordlist/{{$result->date}}">{{$result->date}}</a><input id="{{$result->date}}" type="checkbox"><br>
@endforeach
@endisset
<button id="put">generate</button><br>
@endsection

