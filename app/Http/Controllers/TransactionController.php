<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function deposit(Request $request)
    {        
        $data = $request->all();
        $data['type'] = "I";
        $data['amount'] = abs($data['amount']);
        return $this->accomplish($data);       
    }

    public function withdraw(Request $request)
    {        
        $data = $request->all();        
        $data['type'] = "O";
        $data['amount'] = abs($data['amount'])*-1;
        return $this->accomplish($data);       
    }

    private function accomplish(Array $data)
    {
        try
        {
            if (!Account::find($data['account_id'])) 
            {
                return response()->json(['error'=>'Conta não encontrada'], 404);
            }

            $balance = Transaction::where('account_id', $data['account_id'])->sum('amount');
            if($data['type'] === "O" && $balance<abs($data['amount']))
            {
                return response()->json(['error'=> 'Saldo insuficiente'], 403);
            }

            $new_transaction = Transaction::create($data);
            return response()->json($new_transaction);
        }
        catch(Exception $e)
        {
            return response()->json(['error'=> 'Operação não realizada'], 500);
        }
    }
}
