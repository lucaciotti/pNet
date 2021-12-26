<?php

namespace App\Http\Controllers\sysCtrl;

use App\Models\Role;
use App\Models\User;
use App\Mail\InviteUser;
use App\Helpers\RedisUser;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Models\parideModels\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\parideCtrl\HomeController;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $req)
    {
        $users = User::with(['roles'])
            ->whereHas('roles', function ($q) {
                $q->whereNotIn('name', ['agent', 'superAgent', 'client']);
            })
            ->orderBy('id')->get();

        $agents = User::with(['roles', 'agent', 'client'])
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['agent', 'superAgent']);
            })
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
                $q->whereIn('name', ['client']);
            })
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
        $user->auto_email = $req->input('auto_email');
        $user->save();
        RedisUser::store();

        return ($req->input('role')=='4') ? Redirect::route('user::usersCli') : Redirect::route('user::users.index');
    }

    public function actLike(Request $req, $id)
    {
        Auth::loginUsingId($id);
        RedisUser::store();
        return redirect()->action([HomeController::class, 'index']);
    }

    public function changeSelfDitta(Request $req)
    {
        $user = Auth::user();
        $user->ditta = $req->input('ditta');
        $user->save();
        RedisUser::store();
        return redirect()->action([HomeController::class, 'index']);
    }

    public function changeSelfLang(Request $req)
    {
        $user = Auth::user();
        $user->lang = $req->input('lang');
        $user->save();
        RedisUser::store();
        return redirect()->action([UserController::class, 'show'], $user->id);
    }

    // -----------------------------------
    public function sendResetPassword(Request $req, $id) {
        $user = User::findOrFail($id);
        try{
            $token = Password::getRepository()->create($user);
            $user->isActive = 0;
            $user->save();
            // $user->sendPasswordResetNotification($token);
            if (App::environment(['local', 'staging'])) {
                Mail::to('pnet@lucaciotti.space')->cc(['luca.ciotti@gmail.com'])->send(new InviteUser($token, $user->id));
            } else {
                Mail::to($user->email)->bcc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->send(new InviteUser($token, $user->id));
            }
            Log::info("Invite User: " . $user->name);
            $req->session()->flash('status', 'Inviata email a '.$user->email.'!');
        } catch (\Exception $e) {
            Log::error("Invite User error: ". $e->getMessage());
            $req->session()->flash('status', 'Errore imprevisto per favore riprovare!');
        }
        if(Auth::check()){
            if(Auth::user()->id == $id){
                Auth::logout();
                return redirect('/login');
            } else {
                return redirect()->back();
            }
        } else {
            return
            view('vendor.adminlte.auth.sendedInvite');
        }
        
    }

}
