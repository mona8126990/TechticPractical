@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">My Order</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table width="100%" class="table table-hover">

                            @php $totalAmount=0; @endphp
                            @if(isset($orders) && count($orders) > 0)
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        Order #: {{ str_pad($order->order_number,10,0,STR_PAD_LEFT) }} <br>
                                        Order Date: {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-right">
                                        Rs. {{ number_format($order->grand_total_amount,2) }}<br>
                                        <a href="{{route('order.index',['orderId'=>$order->id])}}" class="btn btn-warning" id="viewOrder">View Order</a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr><td colspan="2">Order Details not found</td></tr>
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
