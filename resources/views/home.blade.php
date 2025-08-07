@extends('layouts.app')

@section('contenido')
    <p>Home View</p>
    <p>{{auth()->user()->name}}</p>
@endsection