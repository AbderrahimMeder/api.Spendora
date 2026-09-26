<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = categories::whereIn('account_id',$request->user()->account()->pluck('id'))
        ->orderBy('id', 'desc')
        ->get();
        return response()->json([
            'status' => 200,
            'categories' => $categories,
        ]);
    } 
}