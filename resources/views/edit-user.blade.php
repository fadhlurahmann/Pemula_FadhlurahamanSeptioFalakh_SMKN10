@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit User</h2>
            <form action="{{route('user.update',$user->id)}}" method="post">
            @csrf
            @method('put')
            <label for="name">Name</label>
            <input type="text" name="name" value="{{$user->name}}" class="form-control">
            <label for="name">username</label>
            <input type="text" name="username" value="{{$user->username}}" class="form-control">
            <label for="name">password</label>
            <input type="text" name="password" value="" class="form-control">
            <button type="submit" class="btn btn-primary">Edit</button>
            <a href="{{ route('home') }}" class="btn btn-primary">kembali</a>
        </form>
    </div>
@endsection