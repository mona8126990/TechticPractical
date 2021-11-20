@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Product List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   <table class="table table-hover">
                       @foreach($products as $product)
                           <tr class="">
                               <td>Name: {{ $product->name }}</br>
                                   Model:{{ $product->model_number }}</br>
{{--                                   {{ $product->description }}--}}
                               </td>
                               <td width="12%">Rs.{{ number_format($product->price,2) }}</td>
                               <td width="12%"><button class="btn btn-success" id="addToCart" name="addToCart" onclick="addToCart({{ $product->id }})">Add to Cart</button></td>
                           </tr>
                       @endforeach
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
       function addToCart(productId)
       {
           $.ajax({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               url: "{{ route('cart.store') }}",
               method: "POST",
               data: {"productId":productId},
               success: function (res) {
                   alert(res.message);
               }
           });
       }
    </script>
@endsection
