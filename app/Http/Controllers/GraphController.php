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
        $year = 2025;
        $month = 03;
        // $month = null;
        $category_id = 1;

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
        }

        // $labels = $data->pluck('date');
        // $totals = $data->pluck('total');

        $date_list = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
        ->whereYear('date', $year)
        ->orderBy('date', 'desc')
        ->get();

        for($i=0; $i < count($date_list); $i++) {
            $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
            $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        }

        //カテゴリ毎の該当期間のグラフ
        if(isset($category_id)) {
            //月の合計金額を取得
            for($i=0; $i < count($date_newArry); $i++) {
                $categories[$i]['month'] = $date_newArry[$i]['month'];
                $categories[$i]['obj'] =  Item::with('secondary_category')
                ->select('secondary_category_id')
                ->where('secondary_category_id', $category_id)
                ->whereMonth('date', $date_newArry[$i]['month'])
                ->selectRaw('SUM(price) as total')
                ->groupBy('secondary_category_id')
                ->get();
            }

            $categories_collect = collect($categories);

            for($i=0; $i < count($date_newArry); $i++) {
                $totals[$i] =  $categories[$i]['obj']->pluck('total');
            }

            $totals_collect = collect($totals);

            dd($categories_collect->pluck('month'),$totals_collect);

        }

        // dd($labels, $totals);

        return Inertia::render('Graph');
    }
}
