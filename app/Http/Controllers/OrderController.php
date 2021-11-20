<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Helpers\Helper;
use App\Order;
use App\OrderItem;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function index($orderId)
    {
        // To get order detail
        $order = Order::with('orderItem')->where(['orders.id' => $orderId])->first();

        // To return order view screen
        return view('order',compact('order'));
    }

    /**
     * To store order details.
     *
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // To get total number of order
            $totalOrder = Order::count();

            // To store and generate order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => str_pad($totalOrder + 1, 10, '0', STR_PAD_LEFT),
                'voucher_id' => isset($request->voucherId) ? $request->voucherId : null,
                'total_amount' => 0,
                'discount_amount' => 0,
                'grand_total_amount' => 0,
            ]);

            $carts = Cart::where(['user_id' => Auth::id()])->get();
            if (isset($carts))
            {
                $orderItems = [];
                $totalAmount = 0;
                foreach ($carts as $cart)
                {
                    $price = isset($cart->product) ? $cart->product->price : 0;
                    $orderItems[] = [
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'product_amount' => $price,
                    ];
                    $totalAmount += $price;
                }

                // To store order items
                OrderItem::insert($orderItems);

                // To calculate voucher discount
                $totalVoucherAmount = 0;
                if (isset($request->voucherId))
                {
                    // To get voucher details
                    $voucher = Voucher::findorFail($request->voucherId);
                    switch($voucher->type)
                    {
                        case Voucher::AMOUNT:
                            if($voucher->discount <= $totalAmount)
                                $totalVoucherAmount = number_format($voucher->discount,2);
                            break;
                        case Voucher::PERCENTAGE:
                            $totalVoucherAmount = number_format((($totalAmount * $voucher->discount) / 100),2);
                            break;
                        default:
                            break;
                    }
                }

                // To update order details
                $order->total_amount = $totalAmount;
                $order->discount_amount = $totalVoucherAmount;
                $order->grand_total_amount = $totalAmount - $totalVoucherAmount;
                $order->save();

                // To remove product from cart
                Cart::where(['user_id' => Auth::id()])->delete();
            }

            DB::commit();

            // To return success response
            return Helper::getReturnStatus("success", "Success", $order->id, "Order placed successfully.");
        }
        catch (\Exception $exception)
        {
            DB::rollBack();

            // Return error
            return Helper::getReturnStatus("error", "", "", $exception->getMessage());
        }
    }

    /**
     * To display user order list screen.
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        try {
            // To get user order details
            $orders = Order::where(['user_id' => Auth::id()])->get();

            // To return order view screen
            return view('orderList',compact('orders'));
        }
        catch (\Exception $exception)
        {
           // Return error
            return Helper::getReturnStatus("error", "", "", $exception->getMessage());
        }
    }
}
