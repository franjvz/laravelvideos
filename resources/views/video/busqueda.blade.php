@section('title', 'Buscar vídeo')
@extends('home')
@section ('content')
    <h2 class="col-lg-8">Videos relacionados con la cadena "{{ $search }}"</h2>
    <div class="col-lg-4">
        <form method="get" action="{{ route('searchVideosByString', $search) }}">
            <label for="filter">Ordenar: </label>
            <select  name="filter">
                <option value="new">Más nuevos</option>
                <option value="old">Más antiguos</option>
                <option value="alfa">De la A a la Z</option>
            </select>
            <input type="submit" value="Filtrar"/>
        </form>
    </div>
    @parent
@endsection



