<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Inertia\Inertia;
use App\Models\Partner;
use App\Models\Subject;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use App\Models\ThirdryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use App\Models\User;
// use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->sortBy == "createAsc") {
            //登録昇順の場合
            $items = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
            ->orderBy('created_at', 'asc')->paginate(20);
        } elseif($request->sortBy == "dateDesc") {
            //日付降順の場合
            $items = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
            ->orderBy('date', 'desc')->paginate(20);
        } elseif($request->sortBy == "dateAsc") {
            //日付昇順の場合
            $items = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
            ->orderBy('date', 'asc')->paginate(20);
        } else {
            //登録降順またはnullの場合
            $request->sortBy = "createDesc";
            $items = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
            ->orderBy('created_at', 'desc')->paginate(20);
        }

        return Inertia::render('Items/Index',[
            'items' => $items,
            'sortBy' => $request->sortBy,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partners = Partner::select('id', 'name')->orderByRaw('CAST(name as CHAR) COLLATE utf8mb4_general_ci asc')->get();
        $primary_categories = PrimaryCategory::with('secondary_category')->select('id', 'name')->get();
        $secondary_categories = SecondaryCategory::with('thirdry_category')->get();
        $thirdry_categories = ThirdryCategory::select('id', 'name')->get();
        $subjects = Subject::select('id', 'name')->get();
        $user_id = Auth::id();

        return Inertia::render('Items/Create', [
            'partners' => $partners,
            'primary_categories' => $primary_categories,
            'secondary_categories' => $secondary_categories,
            'thirdry_categories' => $thirdry_categories,
            'subjects' => $subjects,
            'user_id' => $user_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $request->toArray();

        $validator = Validator::make($request[0], [
            'primary_category_id' => ['required'],
            'date' => ['required'],
            'partner_name' => ['max:100'],
            'secondary_category_id' => ['required'],
            'price' => ['required', 'numeric'],
            'user_id' => ['required'],
        ]);

        if ($validator->fails()) {
            //　バリデーションが失敗した場合

            return to_route('items.create')
            ->with([
                'message' => '必須項目が未入力です。',
                'status' => 'danger'
            ]);

        } else {
            //　バリデーションが成功した場合

            if($request[0]['partner_name']) {

                // もし、登録済みのパートナー名と同じ名前が入力されているか確認
                $old_partner_name = Partner::where('name', $request[0]['partner_name'])
                ->select('name')
                ->first();

                if(is_null($old_partner_name)) {
                // もし、新規パートナー名が入力されていたら新規作成
                    Partner::create([
                        'name' => $request[0]['partner_name'],
                    ]);
                }

                $partner = Partner::select('id')
                ->where('name', $request[0]['partner_name'])
                ->first();

                Item::create([
                    'primary_category_id' => $request[0]['primary_category_id'],
                    'date' => $request[0]['date'],
                    'partner_id' => $partner['id'],
                    'secondary_category_id' => $request[0]['secondary_category_id'],
                    'thirdry_category_id' => $request[0]['thirdry_category_id'],
                    'subject_id' => $request[0]['subject_id'],
                    'price' => $request[0]['price'],
                    'memo' => $request[0]['memo'],
                    'user_id' => $request[0]['user_id'],
                ]);

            } else {

                Item::create([
                    'primary_category_id' => $request[0]['primary_category_id'],
                    'date' => $request[0]['date'],
                    'partner_id' => $request[0]['partner_id'],
                    'secondary_category_id' => $request[0]['secondary_category_id'],
                    'thirdry_category_id' => $request[0]['thirdry_category_id'],
                    'subject_id' => $request[0]['subject_id'],
                    'price' => $request[0]['price'],
                    'memo' => $request[0]['memo'],
                    'user_id' => $request[0]['user_id'],
                ]);

            }

            if($request[1] === true) {
                //連続入力の場合
                return to_route('items.create')
                ->with([
                    'message' => '登録しました。',
                    'status' => 'success',
                ]);
            } else {
                //１件のみ登録の場合
                return to_route('items.index')
                ->with([
                    'message' => '登録しました。',
                    'status' => 'success',
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $itemShow = Item::where('id', $item->id)
        ->with('primary_category', 'secondary_category', 'thirdry_category', 'partner', 'subject', 'user')
        ->get();

        return Inertia::render('Items/Show', [
            'item' => $itemShow,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $itemEdit = Item::where('id', $item->id)
        ->with('primary_category', 'secondary_category', 'thirdry_category', 'partner', 'subject', 'user')
        ->get();
        $partners = Partner::select('id', 'name')->get();
        $primary_categories = PrimaryCategory::with('secondary_category')->select('id', 'name')->get();
        $secondary_categories = SecondaryCategory::with('thirdry_category')->get();
        $thirdry_categories = ThirdryCategory::select('id', 'name')->get();
        $subjects = Subject::select('id', 'name')->get();
        $user_id = Auth::id();

        return Inertia::render('Items/Edit',[
            'item' => $itemEdit,
            'partners' => $partners,
            'primary_categories' => $primary_categories,
            'secondary_categories' => $secondary_categories,
            'thirdry_categories' => $thirdry_categories,
            'subjects' => $subjects,
            'user_id' => $user_id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->primary_category_id = $request->primary_category_id;
        $item->date = $request->date;
        $item->partner_id = $request->partner_id;
        $item->secondary_category_id = $request->secondary_category_id;
        $item->thirdry_category_id = $request->thirdry_category_id;
        $item->subject_id = $request->subject_id;
        $item->price = $request->price;
        $item->memo = $request->memo;
        $item->user_id = $request->user_id;
        $item->save();

        return to_route('items.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return to_route('items.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger'
        ]);
    }
}
