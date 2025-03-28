<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\SecondaryCategory;
use App\Services\Api\ChartService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function chart(Request $request)
    {
        $subQuery = Item::yearMonth($request->year, $request->month);

        if (isset($request->year) && isset($request->month)) {
             //日別の表示

            if(isset($request->category_id)) {

                if($request->category_id == 0) {
                    //全てのカテゴリ

                    list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::dailyAllCategoryGraphs($request->year, $request->month);

                } else {
                    //個別のカテゴリ

                    list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::dailyCategoryGraphs($request->year, $request->month, $request->category_id);

                }

            }

            if(is_null($request->category_id)) {

                if(isset($request->partner_id)) {

                    if($request->partner_id == 0) {
                        //全ての相手先

                        list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::dailyAllPartnerGraphs($request->year, $request->month);

                    } else {
                        //個別の相手先

                        list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::dailyPartnerGraphs($request->year, $request->month, $request->partner_id);

                    }

                }

                if(is_null($request->partner_id)) {

                    list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::dailyGraphs($subQuery);

                }

            }

        } elseif (isset($request->year) && is_null($request->month)) {
            //月別の表示

            if(isset($request->category_id)) {

                if($request->category_id == 0) {
                    // 全てのカテゴリ

                    list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::monthlyAllCategoryGraphs($request->year);

                } else {
                    //個別のカテゴリ

                    list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::monthlyCategoryGraphs($request->year, $request->category_id);

                }

            }

            if(is_null($request->category_id)) {

                if(isset($request->partner_id)) {

                    if($request->partner_id == 0) {
                        //全ての相手先

                        list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::monthlyAllPartnerGraphs($request->year);

                    } else {
                        //個別の相手先

                        list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::monthlyPartnerGraphs($request->year, $request->partner_id);

                    }

                }

                if(is_null($request->partner_id)) {

                    list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::monthlyGraphs($subQuery);

                }
            }


        } elseif(is_null($request->year) && is_null($request->month)) {
            //年別の表示

            if(isset($request->category_id)) {

                if($request->category_id == 0) {
                    //全てのカテゴリ
                    $data = DB::table('items')
                    ->select(DB::raw('secondary_category_id'), DB::raw('SUM(CASE WHEN secondary_categories.primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN secondary_categories.primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('secondary_categories.name as name'), DB::raw('0 as totals'))
                    ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
                    ->groupBy('secondary_category_id')
                    ->orderBy('secondary_category_id', 'asc')
                    ->get();

                    $labels = $data->pluck('name');
                    $totals = $data->pluck('totals');
                    $incomes = $data->pluck('incomes');
                    $outgoes = $data->pluck('outgoes');

                } else {
                    //個別のカテゴリ
                    $data = DB::table('items')
                    ->select(DB::raw('DATE_FORMAT(date, "%Y年") as year'),'secondary_category_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('0 as totals'))
                    ->groupBy(DB::raw('DATE_FORMAT(date, "%Y年")'), 'secondary_category_id')
                    ->where('secondary_category_id', $request->category_id)
                    ->orderBy('year', 'asc')
                    ->get();

                    $labels = $data->pluck('year');
                    $totals = $data->pluck('totals');
                    $incomes = $data->pluck('incomes');
                    $outgoes = $data->pluck('outgoes');

                }

            }

            if(is_null($request->category_id)) {

                if(isset($request->partner_id)) {

                    if($request->partner_id == 0) {
                        //全ての相手先
                        $data = DB::table('items')
                        ->select(DB::raw('partner_id'), DB::raw("
                        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
                        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'), DB::raw('0 as totals'))
                        ->join('partners', 'items.partner_id', '=', 'partners.id')
                        ->groupBy('partner_id')
                        ->orderBy('partner_id', 'asc')
                        ->get();

                        $labels = $data->pluck('name');
                        $totals = $data->pluck('totals');
                        $incomes = $data->pluck('incomes');
                        $outgoes = $data->pluck('outgoes');

                    } else {
                        //個別の相手先
                        $data = DB::table('items')
                        ->select(DB::raw('DATE_FORMAT(date, "%Y年") as year'),'partner_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('0 as totals'))
                        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y年")'), 'partner_id')
                        ->where('partner_id', $request->partner_id)
                        ->orderBy('year', 'asc')
                        ->get();

                        $labels = $data->pluck('year');
                        $totals = $data->pluck('totals');
                        $incomes = $data->pluck('incomes');
                        $outgoes = $data->pluck('outgoes');

                    }

                }

                if(is_null($request->partner_id)) {

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

                }

            }
        }

        return response()->json([
            'data' => $data,
            'labels' => $labels,
            'totals' => $totals,
            'incomes' => $incomes,
            'outgoes' => $outgoes,
        ], Response::HTTP_OK);
    }

    public function table(Request $request)
    {
        //１，Itemモデルからフォーマット化した日付を取得
        $date_list = Item::query()
        ->select(DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
        ->orderBy('date', 'desc')
        ->get();

        //２以降サービスへ切り離した配列を受け取り、変数に代入
        list($total_budgets, $monthly_total_budgets, $all_total) = ChartService::chartTable($date_list, $request->category, $request->partner);

        return response()->json([
            'total_budgets' => $total_budgets,
            'monthly_total_budgets' => $monthly_total_budgets,
            'all_total' => $all_total,
        ], Response::HTTP_OK);
    }
}
