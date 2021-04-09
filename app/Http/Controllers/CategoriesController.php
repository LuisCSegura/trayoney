<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes = Category::where(['user_id' => Auth::user()->id, 'is_income' => true])->latest()->get();
        $expenses = Category::where(['user_id' => Auth::user()->id, 'is_income' => false])->latest()->get();
        return view('categories.index', ['incomes' => $incomes, 'expenses' => $expenses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCategory();
        $category = new Category(request(['category_id', 'name', 'amount', 'is_income']));
        $category->user_id = Auth::user()->id;
        $category->save();
        return redirect('/categories');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->update($this->validateCategory());
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect('/categories');
    }
    protected function validateCategory()
    {
        return request()->validate([
            'name' => 'required',
            'is_income' => 'required',
            'amount' => 'required'
        ]);
    }
}
