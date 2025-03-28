<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function graph ()
    {
        $year = 2025;
        $month = 03;
        // $month = null;
        $category_id = 1;
        $partner_id = 3;

        $category = 1;
        $partner = null;

        // $subQuery = Item::categoryPartner(1, null);

        // //１，Itemモデルからフォーマット化した日付を取得
        // $date_list = Item::query()
        // ->select(DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
        // ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
        // ->orderBy('date', 'desc')
        // ->get();

        // //２，１の日付を更に['year']['month']に分割して新しい配列に代入
        // for($i=0; $i < count($date_list); $i++) {
        //     $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
        //     $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        // }

        // //３，各年の収入と支出の合計を取得
        // $total_budgets = $subQuery
        // ->select(DB::raw("
        // SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        // SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
        // DB::raw('YEAR(date) as year'))
        // ->groupBy(DB::raw('YEAR(date)'))
        // ->orderBy('year', 'desc')
        // ->get();

        // //４，月毎の収入と支出の合計を取得、更にその月に対応する日付を['year']['month']に代入
        // for($i=0; $i < count($date_newArry); $i++) {
        //     $monthly_total_budgets[$i]['total'] = $subQuery
        //     ->select(DB::raw("
        //     SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        //     SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
        //     DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
        //     ->whereYear('date', $date_newArry[$i]['year'])
        //     ->whereMonth('date', $date_newArry[$i]['month'])
        //     ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
        //     ->orderBy('date', 'desc')
        //     ->get();
        //     $monthly_total_budgets[$i]['year'] = $date_newArry[$i]['year'];
        //     $monthly_total_budgets[$i]['month'] = $date_newArry[$i]['month'];
        // }

        // //5，Itemモデルから年のリストを取得
        // $year_list = Item::query()
        // ->select(DB::raw('YEAR(date) as year'))
        // ->groupBy(DB::raw('YEAR(date)'))
        // ->orderBy('year', 'desc')
        // ->get();

        // for($i=0; $i<count($year_list); $i++) {
        //     $year_list[$i]['month'] = Item::query()
        //     ->select(DB::raw('MONTH(date) as month'))
        //     ->whereYear('date', $year_list[$i]['year'])
        //     ->groupBy(DB::raw('MONTH(date)'))
        //     ->orderBy('month', 'desc')
        //     ->get();
        // }

        // //6，Itemモデルから月のリストを取得
        // $month_list = Item::query()
        // ->select(DB::raw('MONTH(date) as month'))
        // ->groupBy(DB::raw('MONTH(date)'))
        // ->orderBy('month', 'desc')
        // ->get();

        // dd($total_budgets, $monthly_total_budgets);

        // $data = DB::table('items')
        // ->select(DB::raw('secondary_category_id'), DB::raw('SUM(price) as totals'), DB::raw('secondary_categories.name as name'),DB::raw('0 as incomes'), DB::raw('0 as outgoes'))
        // ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        // ->groupBy('secondary_category_id')
        // ->whereYear('date', $year)
        // ->whereMonth('date', $month)
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('secondary_category_id'), DB::raw('SUM(price) as totals'), DB::raw('secondary_categories.name as name'),DB::raw('0 as incomes'), DB::raw('0 as outgoes'))
        // ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        // ->groupBy('secondary_category_id')
        // ->whereYear('date', $year)
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('DATE_FORMAT(date, "%c月%e日") as date'),'secondary_category_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('0 as totals'))
        // ->groupBy(DB::raw('date'), 'secondary_category_id')
        // ->whereYear('date', $year)
        // ->whereMonth('date', $month)
        // ->where('secondary_category_id', $category_id)
        // ->orderByRaw('CAST(date as SIGNED) asc')
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('DATE_FORMAT(date, "%Y年%c月") as month'),'secondary_category_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('0 as totals'))
        // ->groupBy('secondary_category_id', DB::raw('DATE_FORMAT(date, "%Y年%c月")'))
        // ->where('secondary_category_id', $category_id)
        // ->whereYear('date', $year)
        // ->orderBy('month', 'asc')
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('partner_id'), DB::raw("
        // SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        // SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'),DB::raw('0 as totals'))
        // ->join('partners', 'items.partner_id', '=', 'partners.id')
        // ->groupBy('partner_id')
        // ->whereYear('date', $year)
        // ->whereMonth('date', $month)
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('partner_id'), DB::raw("
        // SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        // SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'),DB::raw('0 as totals'))
        // ->join('partners', 'items.partner_id', '=', 'partners.id')
        // ->groupBy('partner_id')
        // ->whereYear('date', $year)
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('DATE_FORMAT(date, "%c月%e日") as date'),'partner_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'),DB::raw('0 as totals'))
        // ->groupBy(DB::raw('date'), 'partner_id')
        // ->whereYear('date', $year)
        // ->whereMonth('date', $month)
        // ->where('partner_id', $partner_id)
        // ->orderByRaw('CAST(date as SIGNED) asc')
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('DATE_FORMAT(date, "%Y年%c月") as month'),'partner_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('0 as totals'))
        // ->groupBy(DB::raw('DATE_FORMAT(date, "%Y年%c月")'), 'partner_id')
        // ->whereYear('date', $year)
        // ->where('partner_id', $partner_id)
        // ->orderBy('month', 'asc')
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('secondary_category_id'), DB::raw('SUM(price) as totals'), DB::raw('secondary_categories.name as name'), DB::raw('0 as incomes'), DB::raw('0 as outgoes'))
        // ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        // ->groupBy('secondary_category_id')
        // ->get();

        // $labels = $data->pluck('name');
        // $totals = $data->pluck('totals');
        // $incomes = $data->pluck('incomes');
        // $outgoes = $data->pluck('outgoes');

        // $data = DB::table('items')
        //             ->select(DB::raw('secondary_category_id'), DB::raw('SUM(CASE WHEN secondary_categories.primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN secondary_categories.primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('secondary_categories.name as name'), DB::raw('0 as totals'))
        //             ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        //             ->groupBy('secondary_category_id')
        //             ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('secondary_category_id'), DB::raw('SUM(CASE WHEN secondary_categories.primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN secondary_categories.primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('secondary_categories.name as name'), DB::raw('0 as totals'))
        // ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        // ->groupBy('secondary_category_id')
        // ->whereYear('date', $year)
        // ->get();

        // $data = DB::table('items')
        // ->select(DB::raw('secondary_category_id'), DB::raw('SUM(CASE WHEN secondary_categories.primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN secondary_categories.primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('secondary_categories.name as name'), DB::raw('0 as totals'))
        // ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        // ->groupBy('secondary_category_id')
        // ->whereYear('date', $year)
        // ->whereMonth('date', $month)
        // ->get();

        // $labels = $data->pluck('name');
        // $totals = $data->pluck('totals');
        // $incomes = $data->pluck('incomes');
        // $outgoes = $data->pluck('outgoes');

        // dd($data ,$labels, $totals, $incomes, $outgoes);

        //月毎
        // $data = DB::table('items')
        // ->select(DB::raw('partner_id'), DB::raw("
        // SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        // SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'))
        // ->join('partners', 'items.partner_id', '=', 'partners.id')
        // ->where('partner_id', $partner_id)
        // ->groupBy('partner_id')
        // ->whereYear('date', $year)
        // ->get();

        // //年毎
        // $data = DB::table('items')
        // ->select(DB::raw('partner_id'), DB::raw("
        // SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        // SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'))
        // ->join('partners', 'items.partner_id', '=', 'partners.id')
        // ->where('partner_id', $partner_id)
        // ->groupBy('partner_id')
        // ->get();

        return Inertia::render('Graph');
    }
}
