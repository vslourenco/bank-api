<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

define("INPUT", "I");
define("OUTPUT", "O");
class TransactionController extends Controller
{
    public function deposit(Request $request)
    {        
        $data = $request->all();
        $data['type'] = INPUT;
        $data['amount'] = abs($data['amount']);
        return $this->accomplish($data);       
    }

    public function withdraw(Request $request)
    {        
        $data = $request->all();        
        $data['type'] = OUTPUT;
        $data['amount'] = abs($data['amount'])*-1;
        return $this->accomplish($data);       
    }

    private function accomplish(Array $data)
    {
        try
        {
            Account::findOrFail($data['account_id']); 
            $balance = Transaction::where('account_id', $data['account_id'])->sum('amount');
            if($data['type'] === OUTPUT && $balance<abs($data['amount']))
            {
                return response()->json(['error'=> 'Saldo insuficiente'], 403);
            }

            $new_transaction = Transaction::create($data);
            return response()->json($new_transaction);
        }
        catch(Exception $e)
        {
            return response()->json(['error'=>'Conta não encontrada'], 404);
        }
    }
}
