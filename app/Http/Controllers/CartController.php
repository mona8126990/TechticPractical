<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Helpers\Helper;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * To display cart view screen.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // To get all product which user added into cart
        $carts = Cart::where(['user_id' => Auth::id()])->get();

        // To return cart screen
        return view('cart',compact('carts'));
    }

    /**
     * To store product into cart table
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            // To store product into cart
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->productId,
            ]);

            // To return success response
            return Helper::getReturnStatus("success", "Success", "", "Product added to cart.");
        }
        catch (\Exception $exception)
        {
            // Return error
            return Helper::getReturnStatus("error", "", "", $exception->getMessage());
        }
    }

    /**
     * To remove product from cart.
     *
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
        try {
            // To remove product from cart
           Cart::where(['id' => $request->cartId])->delete();

            // To return success response
            return Helper::getReturnStatus("success", "Success", "", "Product deleted from cart.");
        }
        catch (\Exception $exception)
        {
            // Return error
            return Helper::getReturnStatus("error", "", "", $exception->getMessage());
        }
    }
}
