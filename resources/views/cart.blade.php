@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Cart</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-hover">
                            @php $totalAmount=0; @endphp
                            @if(isset($carts) && count($carts) > 0)
                                <div class="row mt-1 mb-3">
                                    @php
                                        $vouchers = \App\Voucher::get();
                                    @endphp
                                    <select class="form-control" id="voucherId" name="voucherId">
                                        <option value="">-- select voucher --</option>
                                        @foreach($vouchers as $voucher)
                                            <option value="{{$voucher->id}}" data-value="{{$voucher->discount}}" data-type="{{$voucher->type}}">{{$voucher->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @foreach($carts as $cart)
                                <tr>
                                    <td>
                                        Name: {{ $cart->product->name }}</br>
                                        Model:{{ $cart->product->model_number }}</br>
                                        Description:{{ $cart->product->description }}</br>
                                        Price:{{ $cart->product->price }}
                                    </td>
{{--                                    <td>{{ $cart->product->name }} <br> {{ $cart->product->description }}</td>--}}
{{--                                    <td>{{ $cart->product->model_number }} <br> {{ $cart->product->price }}</td>--}}
                                    <td><button class="btn btn-danger" id="deleteFromCart" name="deleteFromCart" onclick="deleteFromCart({{ $cart->id }})">Delete</button></td>
                                </tr>
                           @php $totalAmount += $cart->product->price @endphp

                            @endforeach
                                <input type="hidden" value="{{$totalAmount}}" name="totalAmount" id="totalAmount">
                            <tr>
                                <td>Total Amount(Rs): <span>{{number_format($totalAmount,2)}}</span><br>
                                Voucher Amount(Rs): <span id="voucherAmount">{{number_format(0,2)}}</span><br>
                                Grand Total Amount(Rs): <span id="grandTotalAmount">{{number_format($totalAmount,2)}}</span></td>
                            </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><button class="btn btn-success" id="placeOrder" name="placeOrder" onclick="placeOrder()">Place Order</button></td>
                                </tr>
                            @else
                                <tr><td>Cart is empty</td></tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
        function placeOrder()
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('order.store') }}",
                method: "POST",
                data: {"voucherId": $('#voucherId').val()},
                success: function (res) {
                    alert(res.message);
                    setTimeout(function (){
                        var url = "{{ route('order.index',['orderId' => ':orderId']) }}";
                        url = url.replace(':orderId',res.data);
                        location.href = url;
                    },1000);
                }
            });
        }
        function deleteFromCart(cartId)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('cart.destroy') }}",
                method: "POST",
                data: {"cartId":cartId},
                success: function (res) {
                    alert(res.message);
                    setTimeout(function (){
                        window.location.reload();
                    },1000);
                }
            });
        }
        $(document).ready(function (){
            $("#voucherId").change(function (){
                var voucherId = $(this).val();
                var voucherType = $(this).find(':selected').data('type');
                var voucherDiscount = $(this).find(':selected').data('value');
                var totalAmount = $('#totalAmount').val();
                var discountAmount =0;
                if(voucherId != '') {
                    if (voucherType == "{{ \App\Voucher::AMOUNT }}") {
                        if (totalAmount >= voucherDiscount) {
                            discountAmount = voucherDiscount;
                        } else {
                            alert('you selected wrong voucher');
                        }
                    } else {
                        discountAmount = ((totalAmount * voucherDiscount) / 100);
                    }
                    $('#voucherAmount').text(discountAmount.toFixed(2));
                    $('#grandTotalAmount').text((totalAmount - discountAmount).toFixed(2));
                }
                else
                {
                    $('#voucherAmount').text('0.00');
                    $('#grandTotalAmount').text((totalAmount.toFixed(2)));
                }

            });
        });

    </script>
@endsection
