<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class GraphController extends Controller
{
    public function graph ()
    {
        $year = 202;
        $month = 03;
        // $month = null;
        // $category_id = 0;
        $partner_id = 3;

        //パートナー
        //日毎
        // $data = DB::table('items')
        // ->select(DB::raw('partner_id'), DB::raw("SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'))
        // ->join('partners', 'items.partner_id', '=', 'partners.id')
        // ->where('partner_id', $partner_id)
        // ->groupBy('partner_id')
        // ->whereYear('date', $year)
        // ->whereMonth('date', $month)
        // ->get();

        $data = DB::table('items')
        ->select(DB::raw('DATE_FORMAT(date, "%c月%e日") as date'),'partner_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'))
        ->groupBy(DB::raw('date'), 'partner_id')
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->where('partner_id', $partner_id)
        ->orderByRaw('CAST(date as SIGNED) asc')
        ->get();


        dd($data);

        //月毎
        $data = DB::table('items')
        ->select(DB::raw('partner_id'), DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'))
        ->join('partners', 'items.partner_id', '=', 'partners.id')
        ->where('partner_id', $partner_id)
        ->groupBy('partner_id')
        ->whereYear('date', $year)
        ->get();

        //年毎
        $data = DB::table('items')
        ->select(DB::raw('partner_id'), DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'))
        ->join('partners', 'items.partner_id', '=', 'partners.id')
        ->where('partner_id', $partner_id)
        ->groupBy('partner_id')
        ->get();

        // dd($data);

        //月毎
        // if($category_id == 0) {
        //     $data = DB::table('items')
        //     ->select(DB::raw('secondary_category_id'), DB::raw("
        //     SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        //     SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"), DB::raw('secondary_categories.name as name'))
        //     ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        //     ->groupBy('secondary_category_id')
        //     ->whereYear('date', $year)
        //     ->get();
        // }

        // dd($data);

        //日毎
        // if($category_id == 0) {
        //     $data = DB::table('items')
        //     ->select(DB::raw('secondary_category_id'), DB::raw('SUM(price) as totals'), DB::raw('secondary_categories.name as name'))
        //     ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        //     ->groupBy('secondary_category_id')
        //     ->whereYear('date', $year)
        //     ->whereMonth('date', $month)
        //     ->get();
        // }

        //年毎
        if($category_id == 0) {
            $data = DB::table('items')
            ->select(DB::raw('secondary_category_id'), DB::raw('SUM(price) as totals'), DB::raw('secondary_categories.name as name'))
            ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
            ->groupBy('secondary_category_id')
            ->get();
        }


        if(is_null($month) && isset($year)) {
            //月別の表示
            $data = Item::yearMonth($year, $month)
            ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%m")'))
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo,
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as total"),
            DB::raw('DATE_FORMAT(date, "%Y%m") as month'))
            ->orderBy('month', 'asc')
            ->get();


        } elseif(is_null($year) && is_null($month)) {
            //全期間の表示
            $data = Item::groupBy(DB::raw('YEAR(date)'))
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo,
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as total"),
            DB::raw('YEAR(date) as year'))
            ->orderBy('year', 'asc')
            ->get();


        } else {
            //日別の表示
            $data = Item::yearMonth($year, $month)
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo,
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as total"),
            DB::raw('date'))
            ->groupBy(DB::raw('date'))
            ->orderBy('date', 'asc')
            ->get();

            // dd($data);
        }

        // $labels = $data->pluck('date');
        // dd($labels);
        // $totals = $data->pluck('total');

        $data = DB::table('items')
                ->select(DB::raw('MONTH(date) as month'),'secondary_category_id', DB::raw('SUM(price) as total'))
                ->groupBy('secondary_category_id', DB::raw('MONTH(date)'))
                ->where('secondary_category_id', $category_id)
                ->whereYear('date', $year)
                ->orderBy('month', 'asc')
                ->get();

                dd($data);

        $data = DB::table('items')
        ->select(DB::raw('DATE_FORMAT(date, "%Y年%c月%e日") as date'),'secondary_category_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y年%c月%e日")'), 'secondary_category_id')
        ->where('secondary_category_id', $category_id)
        ->orderBy('date', 'asc')
        ->get();



        // $data = DB::table('items')
        // ->select(DB::raw('MONTH(date) as month'),'secondary_category_id', DB::raw('SUM(price) as total'))
        // ->groupBy('secondary_category_id', DB::raw('MONTH(date)'))
        // ->where('secondary_category_id', $category_id)
        // ->whereYear('date', $year)
        // ->orderBy('month', 'asc')
        // ->get();

        //年毎のカテゴリ別
        //Itemモデルから年のリストを取得
        // $data = DB::table('items')
        // ->select(DB::raw('YEAR(date) as year'),'secondary_category_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'))
        // ->groupBy(DB::raw('YEAR(date)'), 'secondary_category_id')
        // ->where('secondary_category_id', $category_id)
        // ->orderBy('year', 'asc')
        // ->get();

        dd($data);


        // $dat = DB::table('items')
        // ->joinSub($year_list, 'group_year', function($join) {
        //     $join->on('date', '=', 'group_year.year');
        // })
        // ->select('secondary_category_id')
        // ->selectRaw('SUM(price) as total')
        // ->groupBy('secondary_category_id')
        // ->get();

        // $totalCategory = DB::table('items')
        // ->select('secondary_category_id')
        // ->where('secondary_category_id', $category_id)
        // ->selectRaw('SUM(price) as total')
        // ->groupBy('secondary_category_id');

        // $data =  DB::table('items')
        // ->joinSub($totalCategory, 'total', function($join) {
        //     $join->on('total', '=', 'total.total');
        // })
        // ->select(DB::raw('YEAR(date) as year'))
        // ->groupBy(DB::raw('YEAR(date)'))
        // ->orderBy('year', 'desc');

        dd($data->pluck('year'));

        // for($i=0; $i<count($year_list); $i++) {
        //     $categories[$i]['total_collect'] = Item::groupBy(DB::raw('secondary_category_id'))
        //     ->selectRaw('SUM(price) as total')
        //     ->where('secondary_category_id', $category_id)
        //     ->whereYear('date', $year_list[$i]['year'])
        //     ->get();
        //     if(isset($categories[$i]['total_collect'][0])) {
        //         $categories[$i]['total'] = $categories[$i]['total_collect'][0]->toArray();
        //         $total_array[$i] = $categories[$i]['total']['total'];
        //     } else {
        //         $total_array[$i] = 0;
        //     }
        // }

        // $data = Item::groupBy(DB::raw('secondary_category_id'))
        // ->selectRaw('SUM(price) as total')
        // ->where('secondary_category_id', $category_id)
        // ->whereYear('date', $year)
        // ->get();

        // $data = collect($categories);
        // $labels = $year_list->pluck('year');

        dd($data);


        $date_list = Item::query()
        ->select('date')
        ->groupBy('date')
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->orderBy('date', 'asc')
        ->get();

        $date_formated = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%c月%e日") as date'))
        ->groupBy(DB::raw('date'))
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->orderByRaw('CAST(date as SIGNED) asc')
        ->get();


        // dd($date_list);

        // dd($date_list2->pluck('date'));

        // for($i=0; $i < count($date_list); $i++) {
        //     $date_newArry[$i] = ;
        // }

        // $categories = Item::with('secondary_category')
        // ->where('secondary_category_id', $category_id)
        // ->where('date', $date_newArry[0]['date'])
        // ->selectRaw('SUM(price) as total')
        // ->groupBy('secondary_category_id')
        // ->get();

        // dd($categories);

        //月の合計金額を取得
        for($i=0; $i < count($date_list); $i++) {
            $categories[$i]['total_collect'] =  Item::with('secondary_category')
            ->where('secondary_category_id', $category_id)
            ->where('date', $date_list[$i]['date'])
            ->selectRaw('SUM(price) as total')
            ->groupBy('secondary_category_id')
            ->get();
            if(isset($categories[$i]['total_collect'][0])) {
                $categories[$i]['total'] = $categories[$i]['total_collect'][0]->toArray();
                $total_array[$i] = $categories[$i]['total']['total'];
            } else {
                $total_array[$i] = 0;
            }
        }

        $data = collect($categories);
        $labels = $date_formated->pluck('date');

        dd($total_array , $labels);


        // $date_list = Item::query()
        // ->select(DB::raw('DATE_FORMAT(date, "%c%e") as date'))
        // ->groupBy(DB::raw('DATE_FORMAT(date, "%c%e") as date'))
        // ->whereYear('date', $year)
        // ->whereMonth('date', $month)
        // ->orderBy('date', 'asc')
        // ->get();

        // dd($date_list[0]);

        // for($i=0; $i < count($date_list); $i++) {
        //     $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
        //     $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        // }

        // //大カテゴリの収支区分を取得
        // $primary_category = Item::select('primary_category_id')
        // ->where('secondary_category_id', $category_id)
        // ->first();

        // //カテゴリ毎の該当期間のグラフ
        // if(isset($category_id)) {
        //     //月の合計金額を取得
        //     for($i=0; $i < count($date_newArry); $i++) {
        //         $categories[$i]['month'] = $date_newArry[$i]['month'] . '月';
        //         $categories[$i]['total_collect'] =  Item::with('secondary_category')
        //         ->where('secondary_category_id', $category_id)
        //         ->whereMonth('date', $date_newArry[$i]['month'])
        //         ->selectRaw('SUM(price) as total')
        //         ->groupBy('secondary_category_id')
        //         ->get();
        //         if(isset($categories[$i]['total_collect'][0])) {
        //             $categories[$i]['total'] = $categories[$i]['total_collect'][0]->toArray();
        //             $total_array[$i] = $categories[$i]['total']['total'];
        //         } else {
        //             $total_array[$i] = 0;
        //         }
        //     }

        //     $categories_collect = collect($categories);

        //     $totals = collect($total_array);

        //     $labels = $categories_collect->pluck('month');

        //     dd($labels, $totals, $categories);

        // }

        // dd($labels, $totals);

        return Inertia::render('Graph');
    }
}
