<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\SecondaryCategory;
use App\Services\ChartService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function chart(Request $request)
    {
        $subQuery = Item::yearMonth($request->year, $request->month);

        //カテゴリ毎の該当期間のグラフ


        if (isset($request->year) && isset($request->month)) {

            if(isset($request->category_id)) {
                //日別の表示
                $date_list = Item::query()
                ->select('date')
                ->groupBy('date')
                ->whereYear('date', $request->year)
                ->whereMonth('date', $request->month)
                ->orderBy('date', 'asc')
                ->get();

                $date_formated = Item::query()
                ->select(DB::raw('DATE_FORMAT(date, "%c月%e日") as date'))
                ->groupBy(DB::raw('date'))
                ->whereYear('date', $request->year)
                ->whereMonth('date', $request->month)
                ->orderByRaw('CAST(date as SIGNED) asc')
                ->get();

                for($i=0; $i < count($date_list); $i++) {
                    $categories[$i]['total_collect'] =  Item::with('secondary_category')
                    ->where('secondary_category_id', $request->category_id)
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

                //大カテゴリの収支区分を取得
                $primary_category = SecondaryCategory::select('primary_category_id')
                ->where('id', $request->category_id)
                ->first();

                //大カテゴリの収支区分によってグラフ上の表示を変更
                if($primary_category->primary_category_id == 1) {
                    $incomes = collect($total_array);

                    return response()->json([
                        'data' => $data,
                        'labels' => $labels,
                        'incomes' => $incomes,
                    ], Response::HTTP_OK);

                } else {
                    $outgoes = collect($total_array);

                    return response()->json([
                        'data' => $data,
                        'labels' => $labels,
                        'outgoes' => $outgoes,
                    ], Response::HTTP_OK);
                }

            }

            if(is_null($request->category_id)) {
                //日別の表示
                list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::dailyGraphs($subQuery);

                return response()->json([
                    'data' => $data,
                    'labels' => $labels,
                    'totals' => $totals,
                    'incomes' => $incomes,
                    'outgoes' => $outgoes,
                ], Response::HTTP_OK);

            }

        } elseif (isset($request->year) && is_null($request->month)) {

            //カテゴリ毎の該当期間のグラフ
            if(isset($request->category_id)) {
                //月別の表示
                $data = DB::table('items')
                ->select(DB::raw('MONTH(date) as month'),'secondary_category_id', DB::raw('SUM(price) as total'))
                ->groupBy('secondary_category_id', DB::raw('MONTH(date)'))
                ->where('secondary_category_id', $request->category_id)
                ->whereYear('date', $request->year)
                ->orderBy('month', 'asc')
                ->get();

                $labels = $data->pluck('month');

                //大カテゴリの収支区分を取得
                $primary_category = SecondaryCategory::select('primary_category_id')
                ->where('id', $request->category_id)
                ->first();

                //大カテゴリの収支区分によってグラフ上の表示を変更
                if($primary_category->primary_category_id == 1) {
                    $incomes = $data->pluck('total');

                    return response()->json([
                        'data' => $data,
                        'labels' => $labels,
                        'incomes' => $incomes,
                    ], Response::HTTP_OK);

                } else {
                    $outgoes = $data->pluck('total');

                    return response()->json([
                        'data' => $data,
                        'labels' => $labels,
                        'outgoes' => $outgoes,
                    ], Response::HTTP_OK);
                }

            }

            if(is_null($request->category_id)) {
                //月別の表示
                list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::monthlyGraphs($subQuery);

                return response()->json([
                    'data' => $data,
                    'labels' => $labels,
                    'totals' => $totals,
                    'incomes' => $incomes,
                    'outgoes' => $outgoes,
                ], Response::HTTP_OK);
            }


        } elseif(is_null($request->year) && is_null($request->month)) {

            //カテゴリ毎の該当期間のグラフ
            if(isset($request->category_id)) {
                //年別

                $data = DB::table('items')
                ->select(DB::raw('YEAR(date) as year'),'secondary_category_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'))
                ->groupBy(DB::raw('YEAR(date)'), 'secondary_category_id')
                ->where('secondary_category_id', $request->category_id)
                ->orderBy('year', 'asc')
                ->get();

                $labels = $data->pluck('year');

                //大カテゴリの収支区分を取得
                $primary_category = SecondaryCategory::select('primary_category_id')
                ->where('id', $request->category_id)
                ->first();

                //大カテゴリの収支区分によってグラフ上の表示を変更
                if($primary_category->primary_category_id == 1) {
                    $incomes = $data->pluck('incomes');

                    return response()->json([
                        'data' => $data,
                        'labels' => $labels,
                        'incomes' => $incomes,
                    ], Response::HTTP_OK);

                } else {
                    $outgoes = $data->pluck('outgoes');

                    return response()->json([
                        'data' => $data,
                        'labels' => $labels,
                        'outgoes' => $outgoes,
                    ], Response::HTTP_OK);
                }

            }

            if(is_null($request->category_id)) {
                //年別の表示
                $data = Item::select(DB::raw("
                SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
                SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes,
                SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as totals"),
                DB::raw('DATE_FORMAT(date, "%Y年") as date'))
                ->groupBy(DB::raw('DATE_FORMAT(date, "%Y年")'))
                ->orderBy('date', 'asc')
                ->get();

                $labels = $data->pluck('date');
                $totals = $data->pluck('totals');
                $incomes = $data->pluck('incomes');
                $outgoes = $data->pluck('outgoes');

                return response()->json([
                    'data' => $data,
                    'labels' => $labels,
                    'totals' => $totals,
                    'incomes' => $incomes,
                    'outgoes' => $outgoes,
                ], Response::HTTP_OK);
            }
        }
    }
}
