<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use App\Models\ThirdryCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_income = PrimaryCategory::select('id', 'name')
        ->with('secondary_category')
        ->where('id', '=', 1)
        ->get();

        $categories_outgo = PrimaryCategory::select('id', 'name')
        ->with('secondary_category')
        ->where('id', '=', 2)
        ->get();

        $secondary_categories = SecondaryCategory::select('id', 'name')
        ->with('thirdry_category')
        ->get();

        return Inertia::render('Categories/Index',[
            'categories_income' => $categories_income,
            'categories_outgo' => $categories_outgo,
            'secondary_categories' => $secondary_categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $primary_categories = PrimaryCategory::select('id', 'name')
        ->with('secondary_category')
        ->get();

        $secondary_categories = SecondaryCategory::select('id', 'name')
        ->with('thirdry_category')
        ->get();

        return Inertia::render('Categories/Create', [
            'primary_categories' => $primary_categories,
            'secondary_categories' => $secondary_categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {

        //大カテゴリを新規作成
        if($request->secondary_category_name !== null) {
            SecondaryCategory::create([
                'name' => $request->secondary_category_name,
                'primary_category_id' => $request->primary_category_id,
            ]);

            //小カテゴリも新規作成
            if ($request->thirdry_category_name !== null) {
                //作成した大カテゴリを取得
                $secondary_category = SecondaryCategory::select('id')
                ->where('name', '=', $request->secondary_category_name)
                ->get();

                //取得した大カテゴリのidで小カテゴリを作成
                ThirdryCategory::create([
                    'name' => $request->thirdry_category_name,
                    'secondary_category_id' => $secondary_category[0]['id'],
                ]);
            }
        }

        //小カテゴリのみ新規作成
        if($request->secondary_category_id !== null && $request->thirdry_category_name !== null) {
            ThirdryCategory::create([
                'name' => $request->thirdry_category_name,
                'secondary_category_id' => $request->secondary_category_id,
            ]);
        }

        return to_route('categories.index')
        ->with([
            'message' => '作成しました。',
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        $current_secondary_category = SecondaryCategory::with('primary_category')
        ->where('id', '=', $category)
        ->get();

        $current_thirdry_categories = ThirdryCategory::with('secondary_category')
        ->where('secondary_category_id', '=', $category)
        ->get();

        $primary_categories = PrimaryCategory::select('id', 'name')
        ->with('secondary_category')
        ->get();

        $secondary_categories = SecondaryCategory::select('id', 'name')
        ->with('thirdry_category')
        ->get();

        return Inertia::render('Categories/Edit', [
            'current_secondary_category' => $current_secondary_category,
            'current_thirdry_categories' => $current_thirdry_categories,
            'primary_categories' => $primary_categories,
            'secondary_categories' => $secondary_categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, SecondaryCategory $category)
    {

        //大カテゴリ名の変更
        $category->name = $request->secondary_category_name;
        $category->primary_category_id = $request->primary_category_id;
        $category->save();

        //小カテゴリの更新
        if($request->thirdry_category_name !== null) {

            if($request->thirdry_category_id !== null ){
                //小カテゴリ名の変更
                $thirdry_category = ThirdryCategory::where('id', $request->thirdry_category_id)
                ->first();
                $thirdry_category->name = $request->thirdry_category_name;
                $thirdry_category->secondary_category_id = $request->secondary_category_id;
                $thirdry_category->save();

            } else {
                //小カテゴリの新規作成
                ThirdryCategory::create([
                    'name' => $request->thirdry_category_name,
                    'secondary_category_id' => $request->secondary_category_id,
                ]);
            }
        }

        return to_route('categories.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
