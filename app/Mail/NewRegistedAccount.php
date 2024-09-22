<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRegistedAccount extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'New Registered Account',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.registration_congratulations',
            with: [
                'user' => $this->user,
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
