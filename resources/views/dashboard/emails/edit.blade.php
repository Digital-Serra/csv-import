@extends('layouts.dashboard')
@section('title','Editar contato')

@section('content')
    <h3>Editar contato</h3>
    {!! Form::model($email,['url' => route('dashboard.editEmailsPost',['id'=>$email->id])]) !!}
        @include('forms.email')
    <br>
        <button class="btn btn-success" type="submit">Editar</button>
    {!! Form::close() !!}
@stop