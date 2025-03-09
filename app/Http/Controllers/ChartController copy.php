<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Services\ChartService;
use PHPUnit\Framework\Constraint\Count;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class ChartController extends Controller
{
    public function table(Request $request)
    {
        //１，URLパラメータから詳細表示させる年を取得
        $year = $request->total_budget_year;

        //２以降サービスへ切り離した配列を受け取り、変数に代入
        list($total_budgets, $monthly_total_budgets) = ChartService::totalBudgets($year);

        return Inertia::render('Chart/Table', [
            'total_budgets' => $total_budgets,
            'monthly_total_budgets' => $monthly_total_budgets,
            'year' => $year,
        ]);
    }

    public function daily(Request $request)
    {
        // $key = $request->key;
        $key = 0;

        //１，Itemモデルからフォーマット化した日付を取得
        $date_list = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%Y%m") as date'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%m")'))
        ->orderBy('date', 'desc')
        ->get();

        //２以降サービスへ切り離した配列を受け取り、変数に代入
        list($monthly_totals, $items_formated) = ChartService::dailyBudgets($date_list);

        //items詳細ページへのリンク用
        $items = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
        ->select(DB::raw('id'))
        ->get();

        return Inertia::render('Chart/Daily', [
            'items' => $items,
            'monthly_totals' => $monthly_totals,
            'items_formated' => $items_formated,
        ]);
    }

    public function category(){

        //１，Itemモデルからフォーマット化した日付を取得
        $date_list = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%Y%m") as date'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%m")'))
        ->orderBy('date', 'desc')
        ->get();

        //２以降サービスへ切り離した配列を受け取り、変数に代入
        list($monthly_totals, $category_totals) = ChartService::categoryBudgets($date_list);

        return Inertia::render('Chart/Category', [
            'monthly_totals' => $monthly_totals,
            'category_totals' => $category_totals,
        ]);
    }
}
