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

        $data = DB::table('items')
        ->select(DB::raw('secondary_category_id'), DB::raw('SUM(CASE WHEN secondary_categories.primary_category_id = 1 THEN price ELSE 0 END) AS incomes,SUM(CASE WHEN secondary_categories.primary_category_id = 2 THEN price ELSE 0 END) AS outgoes'), DB::raw('secondary_categories.name as name'), DB::raw('0 as totals'))
        ->join('secondary_categories', 'items.secondary_category_id', '=', 'secondary_categories.id')
        ->groupBy('secondary_category_id')
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->get();

        $labels = $data->pluck('name');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        dd($data ,$labels, $totals, $incomes, $outgoes);

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
