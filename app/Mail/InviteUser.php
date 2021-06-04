<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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
        $this->url = route("password.reset", ['token' => $token, 'email' => $this->user->email]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('sysViews._emails.users.invite');
    }
}
