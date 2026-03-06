<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $datas = User::latest()->get();
        return view('admin.user.index', compact('datas'));
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'User Deleted Successfully',
            'alert-type' => 'success'

        );
        return redirect()->back()->with($notification);
    }
}
