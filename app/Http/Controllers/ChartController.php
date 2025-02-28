<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use PHPUnit\Framework\Constraint\Count;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

// use App\Models\Partner;
// use App\Models\Subject;
// use App\Models\PrimaryCategory;
// use App\Models\SecondaryCategory;
// use App\Models\ThirdryCategory;

class ChartController extends Controller
{
    public function table(Request $request)
    {
        $year = $request->total_account_year;

        $total_accounts = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outcome"),
        DB::raw('YEAR(date) as year'))
        ->groupBy(DB::raw('YEAR(date)'))
        ->orderBy('year')
        ->get();

        $monthly_total_accounts = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outcome"),
        DB::raw('MONTH(date) as month'))
        ->whereYear('date', $year)
        ->groupBy(DB::raw('MONTH(date)'))
        ->orderBy('month')
        ->get();

        // dd($total_accounts);

        // $incomes = DB::table('items')
        // ->where('primary_category_id', '=', 1)
        // ->selectRaw('DATE_FORMAT(date, "%Y") AS year')
        // ->selectRaw('SUM(price) AS total_income')
        // ->groupBy('year')
        // ->get();

        // $outcomes = DB::table('items')
        // ->where('primary_category_id', '=', 2)
        // ->selectRaw('DATE_FORMAT(date, "%Y") AS year')
        // ->selectRaw('SUM(price) AS total_outcome')
        // ->groupBy('year')
        // ->get();

        // dd($incomes, $outcomes, $total_accounts);

        // $monthlyTotalIncomes = DB::table('items')
        // ->where('primary_category_id', '=', 1)
        // ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(price) as total'))
        // ->whereYear('date', $year)
        // ->groupBy('primary_category_id')
        // ->orderBy('month')
        // ->get();

        // $monthlyTotalOutcomes = DB::table('items')
        // ->where('primary_category_id', '=', 2)
        // ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(price) as total'))
        // ->whereYear('date', $year)
        // ->groupBy(DB::raw('MONTH(date)'))
        // ->orderBy('month')
        // ->get();

        // $yearTotalIncomes =  DB::table('items')
        // ->where('primary_category_id', '=', 1)
        // ->select(DB::raw('YEAR(date) as year'), DB::raw('SUM(price) as total'))
        // ->whereYear('date', $year)
        // ->groupBy(DB::raw('YEAR(date)'))
        // ->orderBy('year')
        // ->get();

        // $yearTotalOutcomes =  DB::table('items')
        // ->where('primary_category_id', '=', 2)
        // ->select(DB::raw('YEAR(date) as year'), DB::raw('SUM(price) as total'))
        // ->whereYear('date', $year)
        // ->groupBy(DB::raw('YEAR(date)'))
        // ->orderBy('year')
        // ->get();

        // if($incomes->count()>$outcomes->count()) {
        //     foreach($incomes as $income) {
        //         foreach($outcomes as $outcome) {
        //             $total = $income->total_income - $outcome->total_outcome;
        //         }
        //         $total_accounts[] = [$income->year, $income->total_income, $outcome->total_outcome, $total];
        //     }
        // }

        // if($incomes->count()<$outcomes->count()) {
        //     foreach($outcomes as $outcome) {
        //         foreach($incomes as $income) {
        //             $total = $income->total_income - $outcome->total_outcome;
        //         }
        //         $total_accounts[] = [$outcome->year, $income->total_income, $outcome->total_outcome, $total];
        //     }
        // }

        return Inertia::render('Chart/Table', [
            'total_accounts' => $total_accounts,
            'monthly_total_accounts' => $monthly_total_accounts,
            'year' => $year,
            // 'monthlyTotalIncomes' => $monthlyTotalIncomes,
            // 'monthlyTotalOutcome' => $monthlyTotalOutcomes,
            // 'yearTotalIncomes' => $yearTotalIncomes,
            // 'yearTotalOutcomes' => $yearTotalOutcomes,
            // 'incomes' => $incomes,
            // 'outcomes' => $outcomes,
        ]);
    }
}
