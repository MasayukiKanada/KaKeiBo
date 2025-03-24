<?php

namespace App\Services\Api;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ChartService
{

    public static function dailyGraphs($subQuery)
    {
        //日別の表示
        $data = $subQuery
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes,
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as totals"),
        DB::raw('DATE_FORMAT(date, "%c月%e日") as date'))
        ->groupBy(DB::raw('date'))
        ->orderByRaw('CAST(date as SIGNED) asc')
        ->get();

        $labels = $data->pluck('date');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
    }

    public static function monthlyGraphs($subQuery)
    {
        //月別の表示
        $data = $subQuery
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y年%c月")'))
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes,
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as totals"),
        DB::raw('DATE_FORMAT(date, "%Y年%c月") as date'))
        ->orderBy('date', 'asc')
        ->get();

        $labels = $data->pluck('date');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
    }

    public static function dailyAllCategoryGraphs($year, $month)
    {
        $data = DB::table('items')
        ->select(DB::raw('secondary_category_id'), DB::raw('SUM(CASE WHEN secondary_categories.primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN secondary_categories.primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('secondary_categories.name as name'), DB::raw('0 as totals'))
        ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        ->groupBy('secondary_category_id')
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->orderBy('secondary_category_id', 'asc')
        ->get();

        $labels = $data->pluck('name');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];

    }

    public static function monthlyAllCategoryGraphs($year)
     {
        $data = DB::table('items')
        ->select(DB::raw('secondary_category_id'), DB::raw('SUM(CASE WHEN secondary_categories.primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN secondary_categories.primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('secondary_categories.name as name'), DB::raw('0 as totals'))
        ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        ->groupBy('secondary_category_id')
        ->whereYear('date', $year)
        ->orderBy('secondary_category_id', 'asc')
        ->get();

        $labels = $data->pluck('name');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
     }

     public static function dailyCategoryGraphs($year, $month, $category_id)
     {
        $data = DB::table('items')
        ->select(DB::raw('DATE_FORMAT(date, "%c月%e日") as date'),'secondary_category_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('0 as totals'))
        ->groupBy(DB::raw('date'), 'secondary_category_id')
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->where('secondary_category_id', $category_id)
        ->orderByRaw('CAST(date as SIGNED) asc')
        ->get();

        $labels = $data->pluck('date');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
     }

     public static function monthlyCategoryGraphs($year, $category_id)
     {

        $data = DB::table('items')
        ->select(DB::raw('DATE_FORMAT(date, "%Y年%c月") as month'),'secondary_category_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('0 as totals'))
        ->groupBy('secondary_category_id', DB::raw('DATE_FORMAT(date, "%Y年%c月")'))
        ->where('secondary_category_id', $category_id)
        ->whereYear('date', $year)
        ->orderBy('month', 'asc')
        ->get();

        $labels = $data->pluck('month');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
     }

     public static function dailyAllPartnerGraphs($year, $month)
     {
        $data = DB::table('items')
        ->select(DB::raw('partner_id'), DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'),DB::raw('0 as totals'))
        ->join('partners', 'items.partner_id', '=', 'partners.id')
        ->groupBy('partner_id')
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->orderBy('partner_id', 'asc')
        ->get();

        $labels = $data->pluck('name');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
     }

     public static function monthlyAllPartnerGraphs($year)
     {
        $data = DB::table('items')
        ->select(DB::raw('partner_id'), DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes"), DB::raw('partners.name as name'),DB::raw('0 as totals'))
        ->join('partners', 'items.partner_id', '=', 'partners.id')
        ->groupBy('partner_id')
        ->whereYear('date', $year)
        ->orderBy('partner_id', 'asc')
        ->get();

        $labels = $data->pluck('name');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
     }

     public static function dailyPartnerGraphs($year, $month, $partner_id)
     {
        $data = DB::table('items')
        ->select(DB::raw('DATE_FORMAT(date, "%c月%e日") as date'),'partner_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'),DB::raw('0 as totals'))
        ->groupBy(DB::raw('date'), 'partner_id')
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->where('partner_id', $partner_id)
        ->orderByRaw('CAST(date as SIGNED) asc')
        ->get();

        $labels = $data->pluck('date');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
     }

     public static function monthlyPartnerGraphs($year, $partner_id)
     {
        $data = DB::table('items')
        ->select(DB::raw('DATE_FORMAT(date, "%Y年%c月") as month'),'partner_id', DB::raw('SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('0 as totals'))
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y年%c月")'), 'partner_id')
        ->whereYear('date', $year)
        ->where('partner_id', $partner_id)
        ->orderBy('month', 'asc')
        ->get();

        $labels = $data->pluck('month');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
     }

}
