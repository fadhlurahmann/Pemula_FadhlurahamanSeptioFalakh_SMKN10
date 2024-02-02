@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Add User</div>
            </div>
            <div class="card-body">

                <!-- Row start -->
                <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" id="" class="form-control">
                                    <option value="">-- Choose Role --</option>
                                    <option value="bank">admin</option>
                                    <option value="admin">bank</option>
                                    <option value="kantin">kantin</option>
                                    <option value="siswa">siswa</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="username" class="form-control" name="username">
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-actions-footer">
                                <a href="{{ route('home') }}" class="btn btn-success">Kembali</a>
                                <button type="submit" class="btn btn-success">Tambah</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Row end -->
            </div>
        </div>
    </div>
@endsection