<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        $title = "Cart";

        return view('admin.pages.transaction.cart', compact('cartItems', 'title'));
    }

    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'customer' => $request->customer,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);
        Alert::success('Success', 'Product Added to Cart');

        return redirect()->route('product.index');
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return redirect()->route('cart.list');
    }

    public function store()
    {
        if (!\Cart::isEmpty()) {
            DB::beginTransaction();
            try {
                $isi = \Cart::getContent();

                $transaction = Transaction::create([
                    'customer' => auth()->user()->name,
                    'total_amount' => \Cart::getTotal()
                ]);

                $user = User::find(auth()->user()->id);
                $balance = $user->balance;
                $total = \Cart::getTotal();

                if ($balance >= $total) {
                    $decreasebalance = $balance - $total;

                    User::where('id', $user->id)->update(['balance' => $decreasebalance]);
                } else {
                    Alert::error('Failed', 'Balance Tidak Cukup');
                }

                $transaction_details = [];

                foreach ($isi as $product) {
                    $cekproduct = Product::find($product->id);
                    $cekstock = $cekproduct->stock;
                    $qtycheckout = $product->quantity;
                    $pengurangan = $cekstock -= $qtycheckout;

                    Product::where('id', $product->id)->update(['stock' => $pengurangan]);
                    $transaction_details[] = [
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'quantity' => $product->quantity,
                        'amount' => $product->price,
                        'created_at' => Carbon::now()
                    ];
                }

                if ($transaction_details) {
                    TransactionDetail::insert($transaction_details);
                }
                \Cart::clear();
                //Menyimpan data create ke database
                DB::commit();

                Alert::success('Success', 'Product have been bought successfully');

                return redirect()->route('cart.list');
            } catch (\Throwable $th) {
                //melakukan rollback/membatalkan query jika terjadi kesalahan
                DB::rollBack();

                Alert::error('Failed', 'Error');

                return redirect()->route('cart.list');
            }
        } else {
            Alert::error('Failed', 'Nothing in cart');

            return redirect()->route('cart.list');
        }
    }
}
