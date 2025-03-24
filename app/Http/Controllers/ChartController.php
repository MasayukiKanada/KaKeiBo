<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\SecondaryCategory;
use App\Models\Partner;
use App\Services\ChartService;

class ChartController extends Controller
{
    public function index()
    {
        //１，Itemモデルからフォーマット化した日付を取得
        $date_list = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
        ->orderBy('date', 'desc')
        ->get();

        //２以降サービスへ切り離した配列を受け取り、変数に代入
        list($total_budgets, $monthly_total_budgets, $year_list, $month_list) = ChartService::totalBudgets($date_list);

        //大カテゴリの取得
        $categories = SecondaryCategory::select('id', 'name')
        ->get();

        //相手先の取得
        $partners = Partner::select('id', 'name')
        ->get();

        //収支金額の全期間累計を取得
        $all_total = Item::select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo,
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as total"))
        ->first();

        return Inertia::render('Chart/Index', [
            'all_total' => $all_total,
            'total_budgets' => $total_budgets,
            'monthly_total_budgets' => $monthly_total_budgets,
            'year_list' => $year_list,
            'month_list' => $month_list,
            'categories' => $categories,
            'partners' => $partners,
        ]);
    }

    public function daily(Request $request)
    {
        $page = 0;

        if($request->page !== null){
            $page = intval($request->page);
        }

        //１，Itemモデルからフォーマット化した日付を取得
        $date_list = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
        ->orderBy('date', 'desc')
        ->get();

        //２以降サービスへ切り離した配列を受け取り、変数に代入
        list($date_newArry, $monthly_totals, $items_formated) = ChartService::dailyBudgets($date_list, $page);

        //items詳細ページへのリンク用
        $items = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
        ->select(DB::raw('id'))
        ->get();


        return Inertia::render('Chart/Daily', [
            'page' => $page,
            'date_newArry' => $date_newArry,
            'items' => $items,
            'monthly_totals' => $monthly_totals,
            'items_formated' => $items_formated,
        ]);
    }

    public function category(Request $request){
        $page = 0;

        if($request->page !== null){
            $page = intval($request->page);
        }

        //１，Itemモデルからフォーマット化した日付を取得
        $date_list = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
        ->orderBy('date', 'desc')
        ->get();

        //２以降サービスへ切り離した配列を受け取り、変数に代入
        list($date_newArry, $monthly_totals, $category_totals) = ChartService::categoryBudgets($date_list, $page);

        return Inertia::render('Chart/Category', [
            'page' => $page,
            'date_newArry' => $date_newArry,
            'monthly_totals' => $monthly_totals,
            'category_totals' => $category_totals,
        ]);
    }
}
