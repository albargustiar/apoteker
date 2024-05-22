<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Transaction, Drug};
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    public function index() 
    {
    	return view('data/transaction/index', [
    		'transaction' => Transaction::latest()->get()
    	]);
    }

    public function show(Transaction $transaction)
    {
    	return view('data/transaction/show', [
            'transaction' => $transaction
        ]);
    }

    public function add()
    {
    	return view('data/transaction/add', [
            'drugs' => Drug::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedata =  $request->validate([
            'name_customer' => 'required|string|max:255',
            'drug_code' => 'required', // Menyesuaikan validasi untuk array
            'drug_code.*' => 'required|string', // Validasi setiap elemen array
            'qty' => 'required', // Menyesuaikan validasi untuk array
            'qty.*' => 'required|integer', // Validasi setiap elemen array
            'total' => 'required', // Menyesuaikan validasi untuk array
            'total.*' => 'required|numeric', // Validasi setiap elemen array
            'totalsemuanya' => 'required|numeric|min:0',
    
        ]);
        Transaction::create($request->all());
     
        return redirect('transaction');
    }   

    public function edit(Transaction $transaction)
    {
        return view('/data/transaction/edit', [
            'transaction' => $transaction
        ]);
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        // mengambil data dalam semua form
        $data = $request->all();

        // update isi data lalu simpan ke database
        $transaction->update($data);

        // kembali ke halaman transaction sambil membawa session
        return redirect('/transaction')->with('updated', 'transaction has been updated!');
    }

    public function delete(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->to('/transaction')->with('deleted', 'transaction has been deleted!');
    }
    public function deleteAll()
{
    Transaction::truncate();

    return redirect('/transaction')->with('deleted', 'All transactions have been deleted.');
}

}
