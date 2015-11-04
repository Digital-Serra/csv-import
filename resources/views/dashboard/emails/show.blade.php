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
                        <a href="" data-toggle="tooltip" title="Adicionar a uma campanha"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button></a>
                        <a href="{{ route('dashboard.editEmails',['id'=>$email->id]) }}"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit" data-toggle="tooltip" title="Editar"></i></button></a>
                        <a href="#" onclick="click_del('{{ route('dashboard.deleteEmails',['id'=>$email->id]) }}')" data-toggle="tooltip" title="Excluir"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">
        {!! $list_emails->render() !!}
    </div>
@stop