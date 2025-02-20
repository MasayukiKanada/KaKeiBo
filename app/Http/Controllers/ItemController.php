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
use Illuminate\Support\Facades\Auth;
// use App\Models\User;
// use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('partner', 'primary_category', 'secondary_category' ,'subject')
        ->orderBy('date', 'desc')->paginate(20);
        return Inertia::render('Items/Index',[
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partners = Partner::select('id', 'name')->get();
        $primary_categories = PrimaryCategory::select('id', 'name')->get();
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
    public function store(StoreItemRequest $request)
    {

        Item::create([
            'primary_category_id' => $request->primary_category_id,
            'date' => $request->date,
            'partner_id' => $request->partner_id,
            'secondary_category_id' => $request->secondary_category_id,
            'thirdry_category_id' => $request->thirdry_category_id,
            'subject_id' => $request->subject_id,
            'price' => $request->price,
            'memo' => $request->memo,
            'user_id' => $request->user_id,
        ]);

        return to_route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
