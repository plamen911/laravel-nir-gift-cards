<?php

namespace App\Http\Controllers\Admin;

use App\Models\GiftCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $orderCnt = GiftCard::where('status', 'Approved')->count();
        $data = [
            'orderCnt' => $orderCnt
        ];

        return view('admin.dashboard.index', $data);
    }
}
