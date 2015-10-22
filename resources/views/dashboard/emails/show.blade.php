@extends('layouts.dashboard')
@section('title','Importe seus emails')

@section('content')
    <h2>Emails</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list_emails as $email)
            <tr>
                <td>{{ $email->name }}</td>
                <td>{{ $email->email }}</td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">
        {!! $list_emails->render() !!}
    </div>
@stop