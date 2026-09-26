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
    public function show($id){
        $category = categories::whereIn('account_id', $request->user()->account()->pluck('id'))
        ->find($id);

    if (!$category) {
        return response()->json([
            'status' => 404,
            'message' => 'Category not found',
        ], 404);
    }

    return response()->json([
        'status' => 200,
        'category' => $category,
    ]);
    }
    public function create(Request $request)
    {   
        try{
        $account = $request->user()->account;
        if (!$account) {
            return response()->json([
                'status' => 422,
                'message' => 'No accounts found for this user',
            ], 422);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug'=>'required|unique:categories,slug',
            'type' => 'required|in:EXPENSE,INCOME',
            'category_image' => 'nullable|string|max:255',
            'category_color' => 'nullable|string|max:255',
        ]);
        $validated['account_id'] = $account->id;
        $category = categories::create($validated);
        if ($category) {
            return response()->json([
                'status' => 201,
                'message' => 'Category created successfully',
                'category' => $category,
            ], 201);
        }
        return response()->json([
            'status' => 422,
            'message' => 'Failed to create category',
        ], 422);
    }catch(Exception $e){
        return response()->json([
            'status' => 500,
            'message' => 'Internal Server Error. Please try again later.',
        ], 500);
    }
    }
}