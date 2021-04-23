<?php

namespace App\Http\Controllers\sysCtrl;

use App\Models\Role;
use App\Models\User;
use App\Helpers\RedisUser;
use Illuminate\Http\Request;
use App\Models\parideModels\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        $users = User::with(['roles'])
            ->whereHas('roles', function ($q) {
                $q->whereNotIn('name', ['agent', 'superAgent', 'client']);
            })
            ->orderBy('id')->get();

        $agents = User::with(['roles', 'agent'])
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['agent', 'superAgent']);
            })
            ->where('ditta', RedisUser::get('location'))
            ->orderBy('id')->get();

        return view('sysViews.user.index', [
            'users' => $users,
            'agents' => $agents,
        ]);
    }

    public function indexCli(Request $req)
    {
        $clients = User::with(['roles', 'client'])
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['agent', 'client']);
            })
            ->where('ditta', RedisUser::get('location'))
            ->orderBy('id')->get();

        return view('sysViews.user.indexCli', [
            'clients' => $clients,
        ]);
    }

    public function destroy(Request $req, $id)
    {
        User::destroy($id);
        return Redirect::route('user::users.index');
    }

    public function edit(Request $req, $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $clients = Client::select('id_cli_for', 'rag_soc')->get();
        // $agents = Agent::select('codice', 'descrizion')->get();
        // dd($user->roles->contains(33));
        return view('sysViews.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'clients' => $clients,
            'agents' => [],
        ]);
    }

    public function show(Request $req, $id)
    {
        $user = User::findOrFail($id);
        // $ritana = RitAna::first();
        // $year = (string) Carbon::now()->year;
        // $ritmov = RitMov::where('ftdatadoc', '>', new Carbon('first day of January ' . $year))->get();
        return view('sysViews.user.profile', [
            'user' => $user,
            // 'ritana' => $ritana,
            // 'ritmov' => $ritmov,
        ]);
    }

    public function update(Request $req, $id)
    {
        $user = User::findOrFail($id);

        $user->roles()->detach();
        $user->attachRole($req->input('role'));

        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->codag = $req->input('codag');
        $user->codcli = $req->input('codcli');
        $user->isActive = $req->input('isActive');
        $user->save();
        RedisUser::store();

        return Redirect::route('user::users.index');
    }

    public function actLike(Request $req, $id)
    {
        Auth::loginUsingId($id);
        RedisUser::store();
        return redirect()->action('HomeController@index');
    }

    public function changeSelfDitta(Request $req)
    {
        $user = Auth::user();
        $user->ditta = $req->input('ditta');
        $user->save();
        RedisUser::store();
        return redirect()->action('HomeController@index');
    }

    public function changeSelfLang(Request $req)
    {
        $user = Auth::user();
        $user->lang = $req->input('lang');
        $user->save();
        RedisUser::store();
        return redirect()->action('UserController@show', $user->id);
    }
}