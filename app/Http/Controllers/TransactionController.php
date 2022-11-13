<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::get();

        $title = "Transaction List";

        return view('admin.pages.transaction.list', compact('transactions', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.transaction.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'customer' => $request->customer,
                'total_amount' => 200000
            ]);

            $transaction_details = [];

            foreach ($request->orderProducts as $product) {
                $transaction_details[] = [
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'amount' => $product['price'],
                    'created_at' => Carbon::now()
                ];
            }

            if ($transaction_details) {
                TransactionDetail::insert($transaction_details);
            }
            //Menyimpan data create ke database
            DB::commit();
            return "Data Masuk";
        } catch (\Throwable $th) {
            //melakukan rollback/membatalkan query jika terjadi kesalahan
            DB::rollBack();
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $detail = TransactionDetail::where('transaction_id', $transaction->id)->with('product')->get();
        $title = "Details Order";

        return view('admin.pages.transaction.detail', compact('detail', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
