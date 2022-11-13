<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');
        $products = Product::with(['category']);

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($filter) {
            $products->where(function ($query) use ($filter) {
                $query->where('category_id', '=', $filter);
            });
        }

        $products = $products->get();

        $categories = Category::get();
        $title = "Shop Homepage - RabbitZ Store";
        return view('pages.shop', compact('products', 'title', 'categories'));
    }

    public function checkoutList()
    {
        $cartItems = \Cart::getContent();
        $user = User::find(auth()->user()->id);
        $balance = $user->balance;
        $title = "Checkout";

        return view('pages.checkout', compact('cartItems', 'title', 'balance'));
    }

    public function addToCheckout(Request $request)
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

        return redirect()->route('index');
    }

    public function updateCheckout(Request $request)
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

        return redirect()->route('checkout.list');
    }

    public function removeCheckout(Request $request)
    {
        \Cart::remove($request->id);
        Alert::success('Success', 'Product Removed');

        return redirect()->route('checkout.list');
    }

    public function clearAllcheckout()
    {
        \Cart::clear();

        Alert::success('Success', 'All Products Removed');

        return redirect()->route('checkout.list');
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
                $total = intval(\Cart::getTotal());
                $decreasebalance = $balance - $total;

                User::where('id', $user->id)->update(['balance' => $decreasebalance]);

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

                return redirect()->route('checkout.list');
            } catch (\Throwable $th) {
                //melakukan rollback/membatalkan query jika terjadi kesalahan
                DB::rollBack();

                Alert::error('Failed', 'Error');

                return redirect()->route('checkout.list');
            }
        } else {
            Alert::error('Failed', 'Nothing in cart');

            return redirect()->route('checkout.list');
        }
    }
}
