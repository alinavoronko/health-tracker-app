<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{
    public function index()
    {
        if (Gate::denies('is-admin')) {
            return redirect(route('dashboard', ["lang" => App::getLocale()]));
            // ->withErrors('Access denied');
            }
        $users = User::all();
        return view('userList', compact('users'));     
    }
    public function block( Request $req){
        if (Gate::denies('is-admin')) {
            //get user language preference: in nginx
            return redirect(route('dashboard', ["lang" => App::getLocale()]));
            // ->withErrors('Access denied');
            }
        if ($req->blocked==1){
            $user=User::find($req->id);
            $user->unblockUser();
            $user->save();
        }
        else {
            $user=User::find($req->id);
            $user->blockUser();
            $user->save();
        }
        return redirect()->back();
    }
}
