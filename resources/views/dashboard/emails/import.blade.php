@extends('layouts.dashboard')
@section('title','Importe seus emails')

@section('content')
    <h3>Importe seus contatos</h3>

    {!! Form::open(['url' => route('dashboard.postImport'),'files'=>'true']) !!}
        @include('forms.import')
    {!! Form::close() !!}
@stop