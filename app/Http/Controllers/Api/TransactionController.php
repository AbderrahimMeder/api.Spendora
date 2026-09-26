<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transictions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class TransactionController extends Controller
{
public function index(Request $request)
{
    $transactions = Transictions::with(['categories:id,name,type','payment_methods:id,name,type'])
    ->whereIn(
        'account_id',
        $request->user()->account()->pluck('id')
    )
    ->latest('date')
    ->get();

    return response()->json([  

        'status' => 200,
        'message' => 'Failed to fetch transactions',
        'transactions' => $transactions,
    ]);
}

public function show(Request $request, $id)
{
    $transaction = Transictions::with(['categories:id,name,type','payment_methods:id,name,type'])
    ->where('id', $id)
    ->whereIn(
        'account_id',
        $request->user()->account()->pluck('id')
    )
    ->first();

    if (!$transaction) {
        return response()->json([
            'status' => 404,
            'message' => 'Transaction not found',
            'transactions'=>null,
        ], 404);
    }

    return response()->json([
        'status' => 200,
        'message' => 'Transaction found',
        'transaction' => $transaction,
    ]);
    }

        public function POST(Request $request)
    {
        $account = $request->user()->account;
        $validated = $request->validate([
            'amount' => 'required|decimal:2',
            'title' => 'required|string|max:255',
            'type' => 'required|in:EXPENSE,INCOME,TRANSFER',
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'description' => 'nullable|string',
            'currency' => 'required|string|max:3',
            'date' => 'required|date',
            'status' => 'required|in:PENDING,COMPLETED,CANCELLED',
        ]);

        $validated['account_id'] = $account->id;
        $transaction = Transictions::create($validated);
        if (!$transaction) {
            return response()->json([
                'status' => 422,
                'message' => 'Failed to create transaction',
            ], 422);

        }
        return response()->json([
            'status' => 201,
            'message' => 'Transaction created successfully',
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $transaction = Transictions::where('id', $id)
        ->whereIn('account_id', $request->user()->account()->pluck('id'))
        ->first();
        if (!$transaction) {
            return response()->json([
                'status' => 404,
                'message' => 'Transaction not found',
                'transactions'=>null,
            ], 404);
        }
        $validated = $request->validate([
            'amount' => 'required',
            'title' => 'required|string|max:255',
            'type' => 'required|in:EXPENSE,INCOME,TRANSFER',
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'description' => 'nullable|string',
            'currency' => 'required|string|max:3',
            'date' => 'required|date',
            'status' => 'required|in:PENDING,COMPLETED,CANCELLED',
        ]);
        $transaction->update($validated);
        return response()->json([
            'status' => 200,
            'message' => 'Transaction updated successfully',
        ], 200);
    }
    public function delete(Request $request, $id)
    {
        $transaction = Transictions::where('id', $id)
        ->whereIn('account_id', $request->user()->account()->pluck('id'))
        ->first();
        if (!$transaction) {
            return response()->json([
                'status' => 404,
                'message' => 'Transaction not found',
                'transactions'=>null,
            ], 404);
        }
        $transaction->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Transaction deleted successfully',
        ], 200);
    }
    
}
