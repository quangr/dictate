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
    wordjson=window.btoa(JSON.stringify(list));
    window.location.replace("/generate/"+wordjson);
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

