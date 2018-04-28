@section('title', 'Canal de {{ $user->name }}')
@extends('home')
@section ('content')
    <h2 class="col-lg-8">Bienvenidos al canal de "{{ $user->name }}"</h2>
    @parent
@endsection

