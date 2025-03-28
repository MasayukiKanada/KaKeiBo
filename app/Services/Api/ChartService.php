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

     public static function chartTable($date_list, $category, $partner)
     {
        //２，１の日付を更に['year']['month']に分割して新しい配列に代入
        for($i=0; $i < count($date_list); $i++) {
            $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
            $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        }

        if(isset($category) && is_null($partner)) {
            //３，各年の収入と支出の合計を取得
            $total_budgets = DB::table('items')
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
            DB::raw('YEAR(date) as year'))
            ->where('secondary_category_id', $category)
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy('year', 'desc')
            ->get();

            //４，月毎の収入と支出の合計を取得、更にその月に対応する日付を['year']['month']に代入
            for($i=0; $i < count($date_newArry); $i++) {
                $monthly_total_budgets[$i]['total'] =  DB::table('items')
                ->select(DB::raw("
                SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
                SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
                DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
                ->where('secondary_category_id', $category)
                ->whereYear('date', $date_newArry[$i]['year'])
                ->whereMonth('date', $date_newArry[$i]['month'])
                ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
                ->orderBy('date', 'desc')
                ->get();
                $monthly_total_budgets[$i]['year'] = $date_newArry[$i]['year'];
                $monthly_total_budgets[$i]['month'] = $date_newArry[$i]['month'];
            }

            //収支金額の全期間累計を取得
            $all_total = Item::select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo,
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as total"))
            ->where('secondary_category_id', $category)
            ->first();

        } elseif(isset($partner) && is_null($category)) {
            //３，各年の収入と支出の合計を取得
            $total_budgets = DB::table('items')
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
            DB::raw('YEAR(date) as year'))
            ->where('partner_id', $partner)
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy('year', 'desc')
            ->get();

            //４，月毎の収入と支出の合計を取得、更にその月に対応する日付を['year']['month']に代入
            for($i=0; $i < count($date_newArry); $i++) {
                $monthly_total_budgets[$i]['total'] =  DB::table('items')
                ->select(DB::raw("
                SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
                SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
                DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
                ->where('partner_id', $partner)
                ->whereYear('date', $date_newArry[$i]['year'])
                ->whereMonth('date', $date_newArry[$i]['month'])
                ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
                ->orderBy('date', 'desc')
                ->get();
                $monthly_total_budgets[$i]['year'] = $date_newArry[$i]['year'];
                $monthly_total_budgets[$i]['month'] = $date_newArry[$i]['month'];
            }

            //収支金額の全期間累計を取得
            $all_total = Item::select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo,
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as total"))
            ->where('partner_id', $partner)
            ->first();

        } elseif(is_null($category) && is_null($partner)) {
            //３，各年の収入と支出の合計を取得
            $total_budgets = DB::table('items')
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
            DB::raw('YEAR(date) as year'))
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy('year', 'desc')
            ->get();

            //４，月毎の収入と支出の合計を取得、更にその月に対応する日付を['year']['month']に代入
            for($i=0; $i < count($date_newArry); $i++) {
                $monthly_total_budgets[$i]['total'] =  DB::table('items')
                ->select(DB::raw("
                SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
                SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
                DB::raw('DATE_FORMAT(date, "%Y%c") as date'))
                ->whereYear('date', $date_newArry[$i]['year'])
                ->whereMonth('date', $date_newArry[$i]['month'])
                ->groupBy(DB::raw('DATE_FORMAT(date, "%Y%c")'))
                ->orderBy('date', 'desc')
                ->get();
                $monthly_total_budgets[$i]['year'] = $date_newArry[$i]['year'];
                $monthly_total_budgets[$i]['month'] = $date_newArry[$i]['month'];
            }

            //収支金額の全期間累計を取得
            $all_total = Item::select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo,
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) - SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) as total"))
            ->first();
        }

        return [$total_budgets, $monthly_total_budgets, $all_total];
     }

}
