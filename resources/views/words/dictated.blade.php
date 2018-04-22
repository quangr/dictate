@extends('words.app')

@section('title', 'boom')

@section('script')
    @parent <!--这条用于加上原有的内容-->
  $(document).ready(function(){
  $("button#submit").click(function(){
    var list=[];
    $("input:checked").each(function() {
    list.push($(this).attr("id"));
  });
    wordjson=window.btoa(JSON.stringify(list));
      $.post("/user/record",
    {
      data:wordjson,
    },
    function(data,status){
      alert("ok");
      window.location.replace("/user/dictate");
    });
  });
});
@endsection

@section('body')
@isset($words)
@foreach ($words as $word)
<a href="/word/{{$word->word}}">{{$word->word}}</a><input id="{{$word->id}}" type="checkbox"><br>
@endforeach
@endisset
<button id="submit">submit</button>
@endsection


