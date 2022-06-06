<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Individual;
use App\Models\Sacco;
use App\Models\Transaction;

class TestApiController extends Controller
{
    /**
     *most recent transactions with individual and sacco details
     * 
     * @return Response
     */

     public function getTransactions(){
         $transactions = Transaction::leftJoin('individuals','individuals.id','=','transactions.individual_id')
                                    ->leftJoin('saccos','saccos.id','=','individuals.sacco_id')
                                    ->select('individuals.*','saccos.*','transactions.*')
                                    ->orderBy('transactions.id','desc')
                                    ->paginate(10);
         $response_array['transactions'] = $transactions;
         return response()->json($response_array,200);
     }


     /**
      * filter transactions by
      * transaction_id, individual_name, sacco_name, sacco_country, min_amount and max_amount.
      *
      * @param Request
      * @return Response
      *
      */

      public function getFilteredTransactions(Request $request){
            $validator = Validator::make($request->all(), [
              'transaction_id' => 'integer|nullable',
              'individual_name' => 'string|nullable',
              'sacco_name' => 'string|nullable',
              'sacco_country' => 'string|nullable',
              'min_amount' => 'integer|nullable',
              'max_amount' => 'integer|nullable']);
            
            if ($validator->fails()) {
                $response_array['errors'] = $validator;
                return response()->json($response_array,400);
            }

            $transaction_id = $request->input('transaction_id');
            $individual_name = $request->input('individual_name');
            $sacco_name = $request->input('sacco_name');
            $sacco_country = $request->input('sacco_country');
            $min_amount = $request->input('min_amount') ?? 0;
            $max_amount = $request->input('max_amount');

            

            $transactions = Transaction::leftJoin('individuals','individuals.id','=','transactions.individual_id')
                                    ->leftJoin('saccos','saccos.id','=','individuals.sacco_id')
                                    ->select('individuals.*','saccos.*','transactions.*')
                                    ->when($transaction_id, function ($query) use ($transaction_id){
                                        return $query->where([['transactions.id','=',$transaction_id]]);
                                    })
                                    ->when(isset($min_amount) && isset($max_amount), function ($query) use ($min_amount,$max_amount){
                                        return $query->where([['transactions.amount','>=',$min_amount],
                                                                ['transactions.amount','<=',$max_amount]]);
                                    })
                                    ->when($individual_name, function ($query) use ($individual_name){
                                        return $query->where([['individuals.first_name','like','%'.$individual_name.'%']])
                                                     ->orWhere([['individuals.last_name','like','%'.$individual_name.'%']]);
                                    })
                                    ->when($sacco_name, function ($query) use ($sacco_name){
                                        return $query->where([['saccos.name','like','%'.$sacco_name.'%']]);
                                                     
                                    })
                                     ->when($sacco_country, function ($query) use ($sacco_country){
                                        return $query->where([['saccos.country','like','%'.$sacco_country.'%']]);
                                    })
                                    ->orderBy('transactions.id','desc')
                                    ->limit(10)
                                    ->get();
            
            $response_array['transactions'] = $transactions;
            return response()->json($response_array,200);
      }
}
