<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ChartService
{
    public static function totalBudgets($year)
    {
        //２，各年の収入と支出の合計を取得
        $total_budgets = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
        DB::raw('YEAR(date) as year'))
        ->groupBy(DB::raw('YEAR(date)'))
        ->orderBy('year', 'desc')
        ->get();

        //３，１で取得した年に含まれる各月の収入と支出の合計を取得
        $monthly_total_budgets = Item::query()
        ->select(DB::raw("
        SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
        SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"),
        DB::raw('MONTH(date) as month'))
        ->whereYear('date', $year)
        ->groupBy(DB::raw('MONTH(date)'))
        ->orderBy('month', 'desc')
        ->get();

        return [$total_budgets, $monthly_total_budgets];
    }

    public static function dailyBudgets($date_list)
    {
        //２，１の日付を更に['year']['month']に分割して新しい配列に代入
        for($i=0; $i < count($date_list); $i++) {
            $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
            $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        }

        //３，２の['year']['month']と、該当する月のItemモデル内収入と支出合計を新しい配列に代入
        //　配列から各年月に該当する収支を参照できるようにする
        for($i=0; $i < count($date_newArry); $i++) {
            $monthly_totals[$i]['year'] = $date_newArry[$i]['year'];
            $monthly_totals[$i]['month'] = $date_newArry[$i]['month'];
            $monthly_totals[$i]['budget'] = Item::query()
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"))
            ->whereMonth('date',$date_newArry[$i]['month'])
            ->whereYear('date', $date_newArry[$i]['year'])
            ->get();
        }

        //４，2の['year']['month']と、該当する月のItemモデル内の各列を新しい配列に代入
        //　配列から３の年月に該当するItemモデルの各列を参照できるようにする
        for($i=0; $i < count($date_newArry); $i++) {
            $items_formated[$i]['year'] = $date_newArry[$i]['year'];
            $items_formated[$i]['month'] = $date_newArry[$i]['month'];
            $items_formated[$i]['items'] = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
            ->select(DB::raw('id'),
            DB::raw('date'),
            DB::raw('partner_id'),
            DB::raw('primary_category_id'),
            DB::raw('secondary_category_id'),
            DB::raw('subject_id'),
            DB::raw('price')
            )
            ->where(DB::raw('DATE_FORMAT(date, "%Y%m")'), $date_newArry[$i]['year'].$date_newArry[$i]['month'])
            ->orderBy('id','desc','date_format', 'desc')
            ->get();
            $items_formated[$i]['daily_budget'] = Item::query()
            ->select(DB::raw('date'), DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"))
            ->whereMonth('date',$date_newArry[$i]['month'])
            ->whereYear('date', $date_newArry[$i]['year'])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        }

        return [$monthly_totals, $items_formated];
    }

    public static function categoryBudgets($date_list)
    {
        //２，１の日付を更に['year']['month']に分割して新しい配列に代入
        for($i=0; $i < count($date_list); $i++) {
            $date_newArry[$i]['year'] = substr($date_list[$i]->date, 0, 4);
            $date_newArry[$i]['month'] = substr($date_list[$i]->date, 4);
        }

        //３，２の['year']['month']と、該当する月のItemモデル内収入と支出合計を新しい配列に代入
        //　配列から各年月に該当する収支を参照できるようにする
        for($i=0; $i < count($date_newArry); $i++) {
            $monthly_totals[$i]['year'] = $date_newArry[$i]['year'];
            $monthly_totals[$i]['month'] = $date_newArry[$i]['month'];
            $monthly_totals[$i]['budget'] = Item::query()
            ->select(DB::raw("
            SUM(CASE WHEN primary_category_id = 1 THEN price ELSE 0 END) AS income,
            SUM(CASE WHEN primary_category_id = 2 THEN price ELSE 0 END) AS outgo"))
            ->whereMonth('date',$date_newArry[$i]['month'])
            ->whereYear('date', $date_newArry[$i]['year'])
            ->get();
        }

        //４，2の['year']['month']と、該当する月のItemモデル内大カテゴリの合計を新しい配列に代入
        //　配列から３の年月に該当するItemモデルの大カテゴリを参照できるようにする
        for($i=0; $i < count($date_newArry); $i++) {
            $category_totals[$i]['year'] = $date_newArry[$i]['year'];
            $category_totals[$i]['month'] = $date_newArry[$i]['month'];
            $category_totals[$i]['budget'] = Item::with('primary_category', 'secondary_category' ,'thirdry_category')
            ->select('secondary_category_id')
            ->selectRaw('SUM(price) as price')
            ->whereMonth('date',$date_newArry[$i]['month'])
            ->whereYear('date', $date_newArry[$i]['year'])
            ->groupBy('secondary_category_id')
            ->get();
            $category_totals[$i]['thirdry_category'] = Item::with('secondary_category' ,'thirdry_category')
            ->select('thirdry_category_id')
            ->selectRaw('SUM(price) as price')
            ->whereMonth('date',$date_newArry[$i]['month'])
            ->whereYear('date', $date_newArry[$i]['year'])
            ->groupBy('thirdry_category_id')
            ->get();
        }

        return [ $monthly_totals, $category_totals];
    }
}
