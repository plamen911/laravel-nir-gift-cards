<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GiftCardsDataTable;
use App\Http\Controllers\Controller;
use App\Models\GiftCard;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\GiftCardsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(GiftCardsDataTable $dataTable)
    {
        return $dataTable->render('admin.orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param GiftCard $giftCard
     * @return \Illuminate\Http\Response
     */
    public function show(GiftCard $giftCard)
    {
        if ($giftCard->status !== 'Approved') {
            return redirect()->route('admin.orders');
        }

        $data = [
            'giftCard' => $giftCard
        ];

        return view('admin.orders.view', $data);
    }
}
