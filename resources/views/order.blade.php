@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Order Details
                        <a class="btn btn-secondary col-md-3 float-right" href="{{route('order.list')}}">Back to Order List</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-hover">
                            Order #: {{ str_pad($order->order_number,10,0,STR_PAD_LEFT) }} <br>
                            Order Date: {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}
                            @if(isset($order) && isset($order->orderItem) && count($order->orderItem) > 0)
                            @foreach($order->orderItem as $item)
                                <tr><td>
                                    Name: {{ $item->product->name }}</br>
                                    Model:{{ $item->product->model_number }}</br>
                                    Price:{{ $item->product->price }}
                                    </td></tr>
                            @endforeach
                                <tr><td>Total Amount(Rs): {{ number_format($order->total_amount,2) }}</td></tr>
                                <tr><td>Discount Amount(Rs): {{ number_format($order->discount_amount,2) }}</td></tr>
                                <tr><td>Grand Total Amount(Rs): {{ number_format($order->grand_total_amount,2) }}</td></tr>
                            @else
                                <tr><td>Order detail not found</td></tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
