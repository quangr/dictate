@extends('words.app')

@section('title', 'boom')

@section('script')
    @parent <!--这条用于加上原有的内容-->
	


@endsection

@section('body')
@isset($audios)
@foreach ($audios as $audio)
<audio controls src="data:audio/mp3;base64,{{$audio}}"/>
@endforeach
@endisset
@endsection


