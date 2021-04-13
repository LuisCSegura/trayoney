<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->toIndex(null);
    }
    private function toIndex($message)
    {
        $ie = $this->loadIeMonth(date("m"), date("Y"));
        $stats = $this->loadStatsMonth(date("m"), date("Y"));
        // dd($stats);
        return view('home', ['stats' => $stats, 'ie' => $ie, 'title' => "STATS OF THIS MONTH", 'error' => $message]);
    }
    public function show($opt, Request $request)
    {
        $stats = [];
        $ie = [0, 0];
        $title = "STATS OF THIS MONTH";
        if ($opt == 0) {
            $d1 = $request->date1;
            $d2 = $request->date2;
            $stats = $this->loadStatsBetween($d1, $d2);
            $ie = $this->loadIeBetween($d1, $d2);
            $title = "STATS BETWEEN " . $d1 . " AND " . $d2;
        } elseif ($opt == 1) {
            $d2 = date('Y-m-d H:i:s');
            $d1 = date("d-m-Y", strtotime($d2 . "- 1 month"));
            $stats = $this->loadStatsBetween($d1, $d2);
            $ie = $this->loadIeBetween($d1, $d2);
            $title = "STATS OF THE LAST MONTH";
        } elseif ($opt == 2) {
            $d2 = date('Y-m-d H:i:s');
            $d1 = date('Y-m-d H:i:s', strtotime($d2 . "- 1 year"));
            $stats = $this->loadStatsBetween($d1, $d2);
            $ie = $this->loadIeBetween($d1, $d2);
            $title = "STATS OF THE LAST YEAR";
        } elseif ($opt == 3) {
            $month = $request->month;
            $separate = explode("-", $month);
            $month = $separate[1];
            $year = $separate[0];
            $stats = $this->loadStatsMonth($month, $year);
            $ie = $this->loadIeMonth($month, $year);
            $title = "STATS OF THE MONTH " . $month . "-" . $year;
        } else {
            $year = $request->year;
            $stats = $this->loadStatsYear($year);
            $ie = $this->loadIeYear($year);
            $title = "STATS OF THE YEAR " . $year;
        }
        return view('home', ['stats' => $stats, 'ie' => $ie, 'title' => $title, 'error' => null]);
    }
    protected function loadIeMonth($month, $year)
    {
        $ie = [];
        $incomeAmount = Transaction::where([['user_id', '=', Auth::user()->id], ['type', '=', 'INCOME']])
            ->whereMonth('updated_at', '=', $month)->whereYear('updated_at', '=', $year)->sum('amount');
        $expenseAmount = Transaction::where([['user_id', '=', Auth::user()->id], ['type', '=', 'EXPENSE']])
            ->whereMonth('updated_at', '=', $month)->whereYear('updated_at', '=', $year)->sum('amount');
        array_push($ie, $incomeAmount, $expenseAmount);
        return $ie;
    }
    protected function loadIeYear($year)
    {
        $ie = [];
        $incomeAmount = Transaction::where([['user_id', '=', Auth::user()->id], ['type', '=', 'INCOME']])->whereYear('updated_at', '=', $year)->sum('amount');
        $expenseAmount = Transaction::where([['user_id', '=', Auth::user()->id], ['type', '=', 'EXPENSE']])->whereYear('updated_at', '=', $year)->sum('amount');
        array_push($ie, $incomeAmount, $expenseAmount);
        return $ie;
    }
    protected function loadIeBetween($date1, $date2)
    {
        $ie = [];
        $incomeAmount = Transaction::where([['user_id', '=', Auth::user()->id], ['type', '=', 'INCOME']])->whereBetween('updated_at', [$date1, $date2])->sum('amount');
        $expenseAmount = Transaction::where([['user_id', '=', Auth::user()->id], ['type', '=', 'EXPENSE']])->whereBetween('updated_at', [$date1, $date2])->sum('amount');
        array_push($ie, $incomeAmount, $expenseAmount);
        return $ie;
    }

    protected function loadStatsMonth($month, $year)
    {

        $blue = [30, 144, 255];
        $red = [220, 20, 60];
        $stats = [];
        $categories = Category::where(['user_id' => Auth::user()->id, 'category_id' => null])->orderBy('is_income')->get();
        foreach ($categories as $category) {
            $used = Transaction::where([['user_id', '=', Auth::user()->id], ['category_id', '=', $category->id]])
                ->whereMonth('updated_at', '=', $month)->whereYear('updated_at', '=', $year)->sum('amount');
            $sons = [];
            $blueSon = [30, 144, 255];
            $redSon = [225, 20, 60];
            foreach ($category->categories as $son) {
                $usedSon = Transaction::where([['user_id', '=', Auth::user()->id], ['category_id', '=', $son->id]])
                    ->whereMonth('updated_at', '=', $month)->whereYear('updated_at', '=', $year)->sum('amount');
                $used += $usedSon;
                if ($son->is_income) {
                    array_push($sons, [$son->name, $usedSon, $blueSon]);
                    $blueSon[0] += 30;
                    $blueSon[1] += 20;
                } else {
                    array_push($sons, [$son->name, $usedSon, $redSon]);
                    $redSon[1] += 30;
                    $redSon[2] += 30;
                }
            }
            if ($category->is_income) {
                array_push($stats, [$category->name, $used, $blue, $category->id, true, $sons]);
                $blue[0] += 20;
                $blue[1] += 10;
            } else {
                array_push($stats, [$category->name, $used, $red, $category->id, false, $sons]);
                $red[0] += 3;
                $red[1] += 20;
                $red[2] += 15;
            }
        }
        return $stats;
    }
    protected function loadStatsYear($year)
    {

        $blue = [30, 144, 255];
        $red = [220, 20, 60];
        $stats = [];
        $categories = Category::where(['user_id' => Auth::user()->id, 'category_id' => null])->orderBy('is_income')->get();
        foreach ($categories as $category) {
            $used = Transaction::where([['user_id', '=', Auth::user()->id], ['category_id', '=', $category->id]])->whereYear('updated_at', '=', $year)->sum('amount');
            $sons = [];
            $blueSon = [30, 144, 255];
            $redSon = [225, 20, 60];
            foreach ($category->categories as $son) {
                $usedSon = Transaction::where([['user_id', '=', Auth::user()->id], ['category_id', '=', $son->id]])->whereYear('updated_at', '=', $year)->sum('amount');
                $used += $usedSon;
                if ($son->is_income) {
                    array_push($sons, [$son->name, $usedSon, $blueSon]);
                    $blueSon[0] += 30;
                    $blueSon[1] += 20;
                } else {
                    array_push($sons, [$son->name, $usedSon, $redSon]);
                    $redSon[1] += 30;
                    $redSon[2] += 30;
                }
            }
            if ($category->is_income) {
                array_push($stats, [$category->name, $used, $blue, $category->id, true, $sons]);
                $blue[0] += 20;
                $blue[1] += 10;
            } else {
                array_push($stats, [$category->name, $used, $red, $category->id, false, $sons]);
                $red[0] += 3;
                $red[1] += 20;
                $red[2] += 15;
            }
        }
        return $stats;
    }
    protected function loadStatsBetween($date1, $date2)
    {
        $mesactual = date("m");
        $blue = [30, 144, 255];
        $red = [220, 20, 60];
        $stats = [];
        $categories = Category::where(['user_id' => Auth::user()->id, 'category_id' => null])->orderBy('is_income')->get();
        foreach ($categories as $category) {
            $used = Transaction::where([['user_id', '=', Auth::user()->id], ['category_id', '=', $category->id]])->whereBetween('updated_at', [$date1, $date2])->sum('amount');
            $sons = [];
            $blueSon = [30, 144, 255];
            $redSon = [225, 20, 60];
            foreach ($category->categories as $son) {
                $usedSon = Transaction::where([['user_id', '=', Auth::user()->id], ['category_id', '=', $son->id]])->whereBetween('updated_at', [$date1, $date2])->sum('amount');
                $used += $usedSon;
                if ($son->is_income) {
                    array_push($sons, [$son->name, $usedSon, $blueSon]);
                    $blueSon[0] += 30;
                    $blueSon[1] += 20;
                } else {
                    array_push($sons, [$son->name, $usedSon, $redSon]);
                    $redSon[1] += 30;
                    $redSon[2] += 30;
                }
            }
            if ($category->is_income) {
                array_push($stats, [$category->name, $used, $blue, $category->id, true, $sons]);
                $blue[0] += 20;
                $blue[1] += 10;
            } else {
                array_push($stats, [$category->name, $used, $red, $category->id, false, $sons]);
                $red[0] += 3;
                $red[1] += 20;
                $red[2] += 15;
            }
        }
        return $stats;
    }
}
