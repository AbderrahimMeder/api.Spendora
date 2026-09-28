<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Account;

class BudgesController extends Controller
{
    public function index(Request $request)
    {
        try{
            $account = Account::where('user_id', $request->user()->id)->first();
            $budgets = Budget::where('account_id', $account->id)
            ->with('categories')
            ->get();
            return response()->json([
                'status' => 200,
                'message' => 'Budgets retrieved successfully',
                'budgets' => $budgets
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}