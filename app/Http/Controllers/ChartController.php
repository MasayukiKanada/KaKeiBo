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
        $year = $request->total_budget_year;

        $total_budgets = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
        DB::raw('YEAR(date) as year'))
        ->groupBy(DB::raw('YEAR(date)'))
        ->orderBy('year', 'desc')
        ->get();

        // dd($total_budgets);

        $monthly_total_budgets = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
        DB::raw('MONTH(date) as month'))
        ->whereYear('date', $year)
        ->groupBy(DB::raw('MONTH(date)'))
        ->orderBy('month', 'desc')
        ->get();

        // dd($monthly_total_budgets, $monthly_totals, $monthly_totals[0]['date']);

        return Inertia::render('Chart/Table', [
            'total_budgets' => $total_budgets,
            'monthly_total_budgets' => $monthly_total_budgets,
            'year' => $year,
        ]);
    }

    public function daily(Request $request)
    {
        $date_arry = [
            'year' => 2025,
            'month' => 2
        ];

        $date_newArry = [
            [
                'year' => null,
                'month' => null,
            ]
        ];

        $monthly_totals = [
            [
                'year' => null,
                'month' => null,
                'budget' => null,
            ]
        ];

        $date_list = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%Y%m") as date'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%m")'))
        ->orderBy('date', 'desc')
        ->get();

        // dd($date_list[0]->date);

        for($i=0; $i < count($date_list); $i++) {
            $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
            $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        }

        for($i=0; $i < count($date_newArry); $i++) {
            $monthly_totals[$i]['year'] = $date_newArry[$i]['year'];
            $monthly_totals[$i]['month'] = $date_newArry[$i]['month'];
            $monthly_totals[$i]['budget'] = Item::query()
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"))
            ->whereMonth('date',$date_newArry[$i]['month'])
            ->whereYear('date', $date_newArry[$i]['year'])
            ->get();
        }

        foreach($monthly_totals[0]['budget'] as $key => $value) {
            echo $key;
            echo ':';
            echo $value;
        }

        $monthly_total_budgets = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"))
        ->whereMonth('date', $date_arry['month'])
        ->whereYear('date', $date_arry['year'])
        ->get();

        $items = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
        ->whereMonth('date', $date_arry['month'])
        ->whereYear('date', $date_arry['year'])
        ->orderBy('date', 'desc')
        ->paginate(20);

        // dd($monthly_total_budgets);

        return Inertia::render('Chart/Daily', [
            'items' => $items,
            'monthly_total_budgets' => $monthly_total_budgets,
            'year' => $date_arry['year'],
            'month' => $date_arry['month'],
            'date_list' => $date_newArry,
        ]);
    }
}
