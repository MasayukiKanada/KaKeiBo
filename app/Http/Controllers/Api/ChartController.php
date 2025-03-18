<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\ChartService;
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
            list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::dailyGraphs($subQuery);

        } elseif (isset($request->year) && is_null($request->month)) {
            //月別の表示
            list($data ,$labels, $totals, $incomes, $outgoes) = ChartService::monthlyGraphs($subQuery);

        } else {
            //年別の表示
            $data = Item::select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes,
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as totals"),
            DB::raw('YEAR(date) as date'))
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy('date', 'asc')
            ->get();

            $labels = $data->pluck('date');
            $totals = $data->pluck('totals');
            $incomes = $data->pluck('incomes');
            $outgoes = $data->pluck('outgoes');
        }

        return response()->json([
            'data' => $data,
            'labels' => $labels,
            'totals' => $totals,
            'incomes' => $incomes,
            'outgoes' => $outgoes,
        ], Response::HTTP_OK);
    }
}
