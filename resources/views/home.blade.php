@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Auth::user()->role_id == 'bank')
            <div class="col md-12">
                <div class="row">
                    <div class="col">
                        <nav class="navbar-brand bg-success p-4 text-white" style="font-size: 30px">
                            <a class="navbar-brand">selamat datang kembali {{ Auth::user()->name }}</a>
                            <div class="col text-end">
                                <button type="button" class="btn btn-primary px-5" data-bs-target="#formTransfer"
                                    data-bs-toggle="modal">Withdraw</button>
                                <button type="button" class="btn btn-primary px-5" data-bs-target="#formTopUp"
                                    data-bs-toggle="modal">Top Up</button>

                                <!-- Modal -->
                                <form action="/topup-from-bank" method="post">
                                    @csrf
                                    <div class="modal fade" id="formTopUp" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <select  name="user_id "  style="font-size: 20px">
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" style="font-size: 20px">                                                                        
                                                                        {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" name="credit" id=""
                                                            class="form-control" min="10000" value="10000">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Top Up Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Modal Tarik Tunai -->
                                <form action="/withdraw-from-bank" method="post">
                                    @csrf
                                    <div class="modal fade" id="formTransfer" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Withdraw</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <select name="user_id" style="font-size: 20px">
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" style="font-size: 20px">{{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" name="debit" id=""
                                                            class="form-control" min="10000" value="10000">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Withdraw Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End Modal Tarik Tunai -->
                            </div>
                        </nav>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jumlah Nasabah</th>
                            <th>Jumlah Transaksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $nasabah }}</td>
                            <td>{{ $transactionsAll }}</td>
                        </tr>
                    </tbody>
                </table>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="col">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Nasabah</th>
                                <th>Permintaan Saldo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($request_topup as $key => $request)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $request->user->username }}</td>
                                    <td>
                                        @if ($request->credit)
                                            <span class="text-warning">Top Up:</span> {{ number_format($request->credit) }}
                                        @elseif ($request->debit)
                                            <span class="text-danger">Withdraw:</span> {{ number_format($request->debit) }}
                                        @endif

                                    </td>
                                    <form action="{{ route('request_topup') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" id="id" value="{{ $request->id }}">
                                        <td><button type="submit" class="btn btn-primary">SETUJU</button></td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col">
                <div class="card bg-success shadow-sm border-0">
                    <div class="card-header border-0">
                        History Transaction
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($mutasi as $data)
                                <li class="list-group-item">
                                    <div class="d-flex  justify-content-between align-items-center">
                                        <div>
                                            @if ($data->credit)
                                                <span class="text-success fw-bold">Credit : </span>Rp
                                                {{ number_format($data->credit) }}
                                            @else
                                                <span class="text-danger fw-bold">Debit : </span>Rp
                                                {{ number_format($data->debit) }}
                                            @endif
            
                                        </div>
                                        <div class="">
                                            <span class="badge rounded-pill border border-warning text-warning">{{$data->status == 'process' ? 'PROSES' : ''}}</span>
                                            @if ($data->status == 'process')
            
                                            @endif
                                        </div>
                                    </div>
                                    Name : {{ $data->user->name }}
                                    <p class="text-grey">Date : {{ $data->created_at }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                </div>
        @endif
        @if (Auth::user()->role_id == 'siswa')
        <div class="col-md-14">
            <div class="container mb-3">
                    <div class="row">
                        <div class="col">
                            <nav class="navbar navbar-dark bg-primary text-white" style="font-size: 20px">
                                <a class="navbar-brand m-2">selamat datang {{ Auth::user()->name}}</a>
                                <div class="col text-end m-3">
                                    <button type="button" class="btn btn-success px-5" data-bs-target="#formTransfer" data-bs-toggle="modal">Withdraw</button>
                                    <button type="button" class="btn btn-success px-5" data-bs-target="#formTopUp" data-bs-toggle="modal">Top Up</button>

                                    <!-- Modal -->
                                    <form action="{{ route('TopUpNow') }}" method="post">
                                        @csrf
                                        <div class="modal fade" id="formTopUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="number" name="credit" id="" class="form-control" min="10000" value="10000">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Top Up Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Modal Tarik Tunai -->
                                    <form action="{{ route('withdrawNow') }}" method="post">
                                        @csrf
                                        <div class="modal fade" id="formTransfer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Withdraw</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="number" name="debit" id="" class="form-control" min="10000" value="10000">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Withdraw Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Modal Tarik Tunai -->
                                </div>
                                
                            </nav>
                        </div>
                    </div>
                    <div >
                    <div class="col ">
                        <div class="row">
                            <div class="col">Saldo Anda: </div>
                        </div>
                        <div class="row">
                            <div class="col">Rp {{ number_format($saldo) }}</div>
                        </div>

                    </div>                       

                    </div>
                </div>
                @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
</div>
<div class="row">
    <div class="col justify-content-end">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header text-bg-primary fw-bold text-center">Products</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col">
                            <form action="{{ route('addToCart') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ Auth::user()->id}}" name="user_id">
                                <input type="hidden" value="{{ $product->id}}" name="product_id">
                                <input type="hidden" value="{{ $product->price}}" name="price">
                                <div class="card">
                                    <div class="card-header">
                                        {{ $product->name }}
                                    </div>
                                    <div class="card-body">
                                        <img style="width: 150px; height:150px;" src="{{ $product->photo }}">
                                        <div>{{$product->desc}}</div>
                                        <div>Harga: {{ $product->price }}</div>
                                        <div>Stock: {{ $product->stock }}</div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min='1'>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="d-grip gap-2">
                                                    <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                                        </svg> <span style="font-size: 12px;">Tambah</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
            
        </div>
    </div>
    <div class="col-md-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>PRODUK</th>
                <th>TOTAL</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            <td> <ul>
                @foreach($carts as $cart)
                <li>{{ $cart->product->name }} | {{ $cart->quantity}} x Rp {{ number_format($cart->price) }}</li>
                @endforeach
            </ul></td>
            <td>   {{ $total_biaya }}</td>
            <td><form action="{{ route('payNow')}}" method="POST">
                <div class="d-grip gap-2">
                    @csrf
                    <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                </div>
            </form></td>
        </tbody>
    </table>
</div>
<div class="col">
    <div class="card bg-white shadow-sm border-0">
        <div class="card-header border-0">
            History Transaction
        </div>

        <div class="card-body">
            <ul class="list-group">
                @foreach ($mutasi as $data)
                    <li class="list-group-item">
                        <div class="d-flex  justify-content-between align-items-center">
                            <div>
                                @if ($data->credit)
                                    <span class="text-success fw-bold">Credit : </span>Rp
                                    {{ number_format($data->credit) }}
                                @else
                                    <span class="text-danger fw-bold">Debit : </span>Rp
                                    {{ number_format($data->debit) }}
                                @endif

                            </div>
                            <div class="">
                                <span class="badge rounded-pill border border-warning text-warning">{{$data->status == 'process' ? 'PROSES' : ''}}</span>
                                @if ($data->status == 'process')

                                @endif
                            </div>
                        </div>
                        Name : {{ $data->user->name }}
                        <p class="text-grey">Date : {{ $data->created_at }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card ">
        <div class="card-header fw-bold border pb-3 d-flex align-items-center ">
            <i class="bi bi-receipt pe-1" style="font-size: medium;" >
                <span>
                    Transaction History
                </span>    
            </i>
            <span></span>
        </div>
        <div class="card-body">
            <ul class="list-group border-0">
                @foreach ($transactions as $key => $transaction)
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <div class="col fw-bold">
                                {{ $transaction[0]->order_id }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-secondary" style="font-size: 12px">
                                {{ $transaction[0]->created_at }}
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-end align-items-center">
                        <a href="{{ route('download', ['order_code' => $transaction[0]->order_code]) }}" class="btn btn-primary">
                            <i class="bi bi-arrow-down-short">download</i>
                        </a>
                    </div>
                </div>
                @endforeach
            </ul>
        </div>
    </div>
</div>
    @endif
    @if (Auth::user()->role_id == 'kantin')
    <div class="container">
    <nav class="navbar-brand bg-success p-4 text-white" style="font-size: 30px">
        <a class="navbar-brand">selamat datang kembali {{ Auth::user()->name }}</a>
    </nav>
        <div class="row">
            <h2>Daftar Produk</h2>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Stock</th>
                        <th>Stand</th>
                        <th>Category</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td><img style="width: 150px; height:150px;" src="{{ $product->photo }}"></td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->desc }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->stand }}</td>
                            <td>{{ $product->category_id }}</td>
                            <td>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-warning">Detail</a>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">Edit</a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('product.create') }}" class="btn btn-primary">Create Product</a>
        <div class="card ">
        <div class="card-header fw-bold border pb-3 d-flex align-items-center ">
            <i class="bi bi-receipt pe-1" style="font-size: medium;" >
                <span>
                    Transaction History
                </span>    
            </i>
            <span></span>
        </div>
        <div class="card-body">
            <ul class="list-group border-0">
                @foreach ($transactions as $key => $transaction)
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <div class="col fw-bold">
                                {{ $transaction[0]->order_id }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-secondary" style="font-size: 12px">
                                {{ $transaction[0]->created_at }}
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-end align-items-center">
                        <a href="{{ route('download', ['order_code' => $transaction[0]->order_code]) }}" class="btn btn-primary">
                            <i class="bi bi-arrow-down-short">download</i>
                        </a>
                    </div>
                </div>
                @endforeach
            </ul>
        </div>
    </div>
</div>
    @endif
    @if (Auth::user()->role_id == 'admin')
    <div class="container">
        <nav class="navbar-brand bg-warning  p-4 text-black" style="font-size: 30px">
            <a class="navbar-brand">selamat datang kembali {{ Auth::user()->name }}</a>
        </nav>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jumlah User</th>
                    <th>Jumlah Product </th>
                    <th>Jumlah Kategori </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $nasabah }}</td>
                    <td>{{ $products }}</td>
                    <td>{{ $categories }}</td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-xxl-7 col-sm-6 col-12">
                <div class="card bg-warning">
                    <div class="card-header  d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <div class="ms-2">User List</div>
                        </div>
                        <a href="{{ route('user.create') }}" class="btn btn-primary ms-auto">
                            <i class="bi bi-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table v-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->role_id }}</td>
                                            <td>
                                                <a href="{{ route('user.show', $user->id) }}"
                                                    class="btn btn-warning">Detail</a>
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-success">Edit</a>
                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>

         
    <div class="col p-1">
        <div class="card bg-success shadow-sm border-0">
            <div class="card-header border-0">
                History Transaction
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($mutasi as $data)
                        <li class="list-group-item">
                            <div class="d-flex  justify-content-between align-items-center">
                                <div>
                                    @if ($data->credit)
                                        <span class="text-success fw-bold">Credit : </span>Rp
                                        {{ number_format($data->credit) }}
                                    @else
                                        <span class="text-danger fw-bold">Debit : </span>Rp
                                        {{ number_format($data->debit) }}
                                    @endif
    
                                </div>
                                <div class="">
                                    <span class="badge rounded-pill border border-warning text-warning">{{$data->status == 'process' ? 'PROSES' : ''}}</span>
                                    @if ($data->status == 'process')
    
                                    @endif
                                </div>
                            </div>
                            Name : {{ $data->user->name }}
                            <p class="text-grey">Date : {{ $data->created_at }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
    @endif
@endsection
