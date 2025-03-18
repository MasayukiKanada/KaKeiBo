<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ChartService
{
    public static function totalBudgets($date_list)
    {
        //２，１の日付を更に['year']['month']に分割して新しい配列に代入
        for($i=0; $i < count($date_list); $i++) {
            $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
            $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        }

        //３，各年の収入と支出の合計を取得
        $total_budgets = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
        DB::raw('YEAR(date) as year'))
        ->groupBy(DB::raw('YEAR(date)'))
        ->orderBy('year', 'desc')
        ->get();

        //４，月毎の収入と支出の合計を取得、更にその月に対応する日付を['year']['month']に代入
        for($i=0; $i < count($date_newArry); $i++) {
            $monthly_total_budgets[$i]['total'] = Item::query()
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

        //5，Itemモデルから年のリストを取得
        $year_list = Item::query()
        ->select(DB::raw('YEAR(date) as year'))
        ->groupBy(DB::raw('YEAR(date)'))
        ->orderBy('year', 'desc')
        ->get();

        for($i=0; $i<count($year_list); $i++) {
            $year_list[$i]['month'] = Item::query()
            ->select(DB::raw('MONTH(date) as month'))
            ->whereYear('date', $year_list[$i]['year'])
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy('month', 'desc')
            ->get();
        }

        //6，Itemモデルから月のリストを取得
        $month_list = Item::query()
        ->select(DB::raw('MONTH(date) as month'))
        ->groupBy(DB::raw('MONTH(date)'))
        ->orderBy('month', 'desc')
        ->get();

        return [$total_budgets, $monthly_total_budgets, $year_list, $month_list];
    }

    public static function dailyBudgets($date_list, $page)
    {
        //２，１の日付を更に['year']['month']に分割して新しい配列に代入
        for($i=0; $i < count($date_list); $i++) {
            $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
            $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        }

        $monthly_totals = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"))
        ->whereMonth('date',$date_newArry[$page]['month'])
        ->whereYear('date', $date_newArry[$page]['year'])
        ->get();

        //４，2の['year']['month']と、該当する月のItemモデル内の各列を新しい配列に代入
        //　配列から３の年月に該当するItemモデルの各列を参照できるようにする
        $items_formated['items'] = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
        ->select(DB::raw('id'),
        DB::raw('date'),
        DB::raw('partner_id'),
        DB::raw('primary_category_id'),
        DB::raw('secondary_category_id'),
        DB::raw('subject_id'),
        DB::raw('price')
        )
        ->where(DB::raw('DATE_FORMAT(date, "%Y%c")'), $date_newArry[$page]['year'].$date_newArry[$page]['month'])
        ->orderBy('id','desc','date_format', 'desc')
        ->get();
        $items_formated['daily_budget'] = Item::query()
        ->select(DB::raw('date'), DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"))
        ->whereMonth('date',$date_newArry[$page]['month'])
        ->whereYear('date', $date_newArry[$page]['year'])
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

        return [$date_newArry, $monthly_totals, $items_formated];
    }

    public static function categoryBudgets($date_list, $page)
    {
        //２，１の日付を更に['year']['month']に分割して新しい配列に代入
        for($i=0; $i < count($date_list); $i++) {
            $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
            $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        }

        //３，２の['year']['month']と、該当する月のItemモデル内収入と支出合計を新しい配列に代入
        //　配列から各年月に該当する収支を参照できるようにする
        $monthly_totals = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"))
        ->whereMonth('date',$date_newArry[$page]['month'])
        ->whereYear('date', $date_newArry[$page]['year'])
        ->get();

        //４，2の['year']['month']と、該当する月のItemモデル内大カテゴリの合計を新しい配列に代入
        //　配列から３の年月に該当するItemモデルの大カテゴリを参照できるようにする
        $category_totals['budget'] = Item::with('primary_category', 'secondary_category' ,'thirdry_category')
        ->select('secondary_category_id')
        ->selectRaw('SUM(price) as price')
        ->whereMonth('date',$date_newArry[$page]['month'])
        ->whereYear('date', $date_newArry[$page]['year'])
        ->groupBy('secondary_category_id')
        ->get();
        $category_totals['thirdry_category'] = Item::with('secondary_category' ,'thirdry_category')
        ->select('thirdry_category_id')
        ->selectRaw('SUM(price) as price')
        ->whereMonth('date',$date_newArry[$page]['month'])
        ->whereYear('date', $date_newArry[$page]['year'])
        ->groupBy('thirdry_category_id')
        ->get();

        return [$date_newArry, $monthly_totals, $category_totals];
    }

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
        ->orderBy('date', 'desc')
        ->get();

        $labels = $data->pluck('date');
        $totals = $data->pluck('totals');
        $incomes = $data->pluck('incomes');
        $outgoes = $data->pluck('outgoes');

        return [$data ,$labels, $totals, $incomes, $outgoes];
    }

    public static function monthlyGraphs($subQuery)
    {
        //２，月別の表示
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
}
