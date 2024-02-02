@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Produk</h2>
        <table class="table table-bordered">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Photo</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Stok</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td><img style="width: 150px; height:150px;" src="{{ $product->photo }}"></td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->desc}}</td>
                    <td>{{$product->stock}}</td>
                </tr>
            </tbody>
        </table>
        <a href="/home" class="btn btn-primary">Kembali</a>
    </div>
@endsection