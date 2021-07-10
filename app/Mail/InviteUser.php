<?php

namespace App\Mail;

use App\Models\User;
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
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $id)
    {
        $this->user = User::findOrFail($id);
        $this->token = $token;
        $this->url = route("password.reset", ['token' => $token, 'nickname' => $this->user->nickname]);
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
        return $this->from($from)
                    ->subject('Invito alla registrazione Ferramenta Paride')
                    ->markdown('sysViews._emails.users.invite');
    }
}
