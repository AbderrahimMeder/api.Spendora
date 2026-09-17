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
                ->where('is_active_method',true)
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
}