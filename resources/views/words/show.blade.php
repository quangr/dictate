@extends('words.app')

@section('title', 'boom')

@section('script')
    @parent <!--这条用于加上原有的内容-->
	
$(document).ready(function(){
  $("button#put").click(function(){
	var txt=$("#words").val();
	txt=txt.replace(/\n/g,";");
    $.post("/user/add",
    {
      data:txt,
      date:$("#date").val(),
    },
    function(data,status){
      alert("数据：" + data + "\n状态：" + status);
    });
  });
  $(".delete").click(function(){
  $.post("/user/delete",
    {
      id:this.id,
    },
    function(data,status){
      alert("ok");
      location.reload();
    });
  });
  });

@endsection

@section('body')
@isset($results)    
<textarea id="words"></textarea><br />
<input type="text" id='date' value="{{date("Ymd")}}"><br />
<button id="put">submit</button>
</form>
<br>
@endisset
@isset($results)
@foreach ($results as $result)
<a href="/user/wordlist/{{$result->date}}">{{$result->date}}</a>:{{$result->count}}<br>
@endforeach
@endisset
@isset($words)
@foreach ($words as $word)
<a href="/word/{{$word->word}}">{{$word->word}}</a><button class="delete" id="{{$word->id}}">delete</button><br>
@endforeach
@endisset

@endsection

