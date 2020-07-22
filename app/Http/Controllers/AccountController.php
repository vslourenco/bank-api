<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;

class AccountController extends Controller
{
    public function index()
    {        
        $accounts = Account::all();
        return response()->json($accounts->toArray());
    }

    public function balance($id)
    {        
        if(Account::find($id))
        {
            $balance = Transaction::where('account_id', $id)->sum('amount');
            return response()->json(['balance'=>$balance]);
        }
        else
        {
            return response()->json(['error'=>'Conta não encontrada'], 404);
        }

        
    }
}
