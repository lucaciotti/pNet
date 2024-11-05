<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteUser extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $user;
    public $url;
    public $hasToPrivacyAgree = false;
    public $daysLeftAgree = 14;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $id)
    {
        $this->user = User::with(['roles', 'client', 'privacyAgreement'])->findOrFail($id);
        $this->token = $token;
        $this->url = route("password.reset", ['token' => $token, 'nickname' => $this->user->nickname]);
        if($this->user->roles->first()->name == 'client') {
            if ($this->user->privacyAgreement && !$this->user->privacyAgreement->privacy_agreement) $this->hasToPrivacyAgree = true;
        }
        if($this->hasToPrivacyAgree) {
            $this->daysLeftAgree = $this->daysLeftAgree - $this->user->privacyAgreement->created_at->diffInDays(Carbon::now());
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->user->invitato_email = true;
        $this->user->save();
        Log::info('Invio Invito a ' . $this->user->name);
        $from = 'amministrazione@ferramentaparide.it';
        return $this->from($from, 'pNet - Ferramenta Paride')
                    ->subject('Invito alla registrazione Ferramenta Paride')
                    ->markdown('sysViews._emails.users.invite');
    }
}
