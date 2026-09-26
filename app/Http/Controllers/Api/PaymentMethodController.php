<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $paymentMethods = PaymentMethod::whereIn('account_id',$request->user()->account()->pluck('id'))
                ->orderBy('id', 'desc')
                ->get();
         if ($paymentMethods->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'No accounts found for this user',
                'payment_methods' => [],
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Payment methods fetched successfully',
            'payment_methods' => $paymentMethods,
        ]);
    }
    public function show(Request $request,$id)
    {
        $paymentMethod = PaymentMethod::where('id', $id)
        ->whereIn('account_id', $request->user()->account()->pluck('id'))
        ->first();
        if (!$paymentMethod) {
            return response()->json([
                'status' => 404,
                'message' => 'Payment method not found',
                'payment_methods' => null,
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Payment method found',
            'payment_method' => $paymentMethod,
        ]);
    }
    public function create(Request $request)
    {   
    $account = $request->user()->account;
    if(!$account)return response()->json([
        'status' => 422,
        'message' => 'No accounts found for this user',
    ], 422);
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:CASH,CARD,BANK,ONLINE,MOBILE,OTHER',
        'is_active_method' => 'required|boolean',
    ]);
    $validated['account_id'] = $account->id;
    $paymentMethod = PaymentMethod::create($validated);
    if($paymentMethod){
    return response()->json([
            'status' => 201,
            'message' => 'Payment method created successfully',
    ],201);
    }
    return response()->json([
            'status' => 422,
            'message' => 'Failed to create payment method',
    ], 422);
}
    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::where('id', $id)
        ->whereIn('account_id', $request->user()->account()->pluck('id'))
        ->first();
        if (!$paymentMethod) {
            return response()->json([
                'status' => 404,
                'message' => 'Payment method not found',
                'payment_methods' => null,
            ], 404);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:CASH,DEBIT_CARD,CREDIT_CARD,BANK_TRANSFER,CHECK,OTHER',
            'account_id' => 'required|exists:accounts,id',
            'is_active_method' => 'required|boolean',
        ]);
        $paymentMethod->update($validated);
        return response()->json([
            'status' => 200,
            'message' => 'Payment method updated successfully',
        ]);
    }
}