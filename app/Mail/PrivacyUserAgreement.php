<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrivacyUserAgreement extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->user = User::with(['roles', 'client', 'privacyAgreement'])->findOrFail($id);
        $this->url = url("privacyPolicy/".$id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info('Privacy Agreement a ' . $this->user->name);
        $from = 'amministrazione@ferramentaparide.it';
        return $this->from($from, 'pNet - Ferramenta Paride')
        ->subject('Invito alla registrazione Ferramenta Paride')
        ->markdown('sysViews._emails.privacy.agreement');
    }
}
