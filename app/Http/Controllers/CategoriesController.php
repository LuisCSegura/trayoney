<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
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
        return $this->toIndex(null);
    }
    private function toIndex($message)
    {
        $mesactual = date("m");
        $status = [];
        $categories = Category::where(['user_id' => Auth::user()->id, 'category_id' => null])->get();
        foreach ($categories as $category) {
            $used = Transaction::where([['user_id', '=', Auth::user()->id], ['category_id', '=', $category->id]])->whereMonth('updated_at', '=', $mesactual)->sum('amount');
            $status[$category->id] = $used;
            foreach ($category->categories as $son) {
                $usedSon = Transaction::where([['user_id', '=', Auth::user()->id], ['category_id', '=', $son->id]])->whereMonth('updated_at', '=', $mesactual)->sum('amount');
                $status[$category->id] += $usedSon;
                $status[$son->id] = $usedSon;
            }
        }
        // dd($status);
        $incomes = Category::where(['user_id' => Auth::user()->id, 'is_income' => true])->latest()->get();
        $expenses = Category::where(['user_id' => Auth::user()->id, 'is_income' => false])->latest()->get();
        return view('categories.index', ['incomes' => $incomes, 'expenses' => $expenses, 'status' => $status, 'error' => $message]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validateCategory();
            $category = new Category(request(['category_id', 'name', 'amount', 'is_income']));
            $category->user_id = Auth::user()->id;
            $category->save();
            return redirect('/categories');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
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
        try {
            $category->update($this->validateCategory());
            return redirect('/categories');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect('/categories');
        } catch (\Throwable $th) {
            return $this->toIndex($th->getMessage());
        }
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
