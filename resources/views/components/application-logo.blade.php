@props(['width'])
<img {{$attributes->merge(['width' => $width.'%'])}} src="{{asset('img/logo.png')}}" width="30%">