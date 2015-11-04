@extends('layouts.dashboard')
@section('title','Importe seus emails')

@section('content')
    <h2>Emails</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list_emails as $email)
            <tr>
                <td>{{ $email->name }}</td>
                <td>{{ $email->email }}</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary"><i class="fa fa-plus" data-toggle="tooltip" title="Adicionar a uma campanha"></i></button>
                        <button type="button" class="btn btn-warning"><i class="fa fa-edit" data-toggle="tooltip" title="Editar"></i></button>
                        <button type="button" class="btn btn-danger"><i class="fa fa-times" data-toggle="tooltip" title="Excluir"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">
        {!! $list_emails->render() !!}
    </div>
@stop