@extends('words.app')

@section('title', 'boom')

@section('script')
    @parent <!--这条用于加上原有的内容-->
	  $(document).ready(function(){
	    $("button#submit").click(function(){
      $.post("/user/recordd",
    {
      data:'{{$word}}',
    },
    function(data,status){
      window.location.replace("/user/dictated/{{$word}}");
    });
  });
});


@endsection

@section('body')
@isset($audios)
@foreach ($audios as $audio)
<audio controls src="data:audio/mp3;base64,{{$audio}}"></audio><br>
@endforeach
<button id="submit">finish</button><br>
@endisset
@endsection


