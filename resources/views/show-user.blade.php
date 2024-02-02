@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail User</h2>
        <table class="table table-bordered">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->password}}</td>
                </tr>
            </tbody>
        </table>
        <a href="/home" class="btn btn-primary">Kembali</a>
    </div>
@endsection