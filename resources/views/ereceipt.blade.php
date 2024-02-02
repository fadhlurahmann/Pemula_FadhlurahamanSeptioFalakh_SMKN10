@extends('layouts.app')

{{-- @php
    function rupiah($angka){
        $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
@endphp --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header fw-bold">                                               
                                    e-Receipt #{{ $transactions[0]->order_id }}                                                            
                                <span class="text-secondary">{{ $transactions[0]->created_at }}</span>
                            </div>
                            <div class="container ms-2 mb-1">
                                {{ $transactions[0]->user }}
                            </div>
                            <div class="card-body border">
                                @foreach ($transactions as $transaction)
                                    <div class="row" style="font-size: 15px">
                                        <div class="col d-flex justify-content-start">
                                            {{ $transaction->product->name }}
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            {{ $transaction->quantity }} *  
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            {{ number_format($transaction->price) }}    
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer px-5">                            
                                <div class="row">
                                    <div class="col d-flex justify-content-start">
                                        Total:
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        {{ number_format($total_biaya) }}
                                    </div>
                                </div>                           
                            </div>
                        </div>
                        <script>
                            window.print();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection