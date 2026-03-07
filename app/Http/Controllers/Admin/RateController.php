<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index()
    {
        $datas = Rate::latest()->get();
        return view('admin.rate.index', compact('datas'));
    }


    public function edit($id)
    {
        $data = Rate::findOrFail($id);
        return view('admin.rate.edit', compact('data'));
    }
}
