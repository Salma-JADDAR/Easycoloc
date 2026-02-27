<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation; // Cette variable sera accessible dans la vue de l'email

    /**
     * Quand on crée une nouvelle instance de cet email
     * On lui passe l'invitation qu'on veut envoyer
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Définit l'enveloppe de l'email (le sujet, etc.)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation à rejoindre une colocation sur EasyColoc',
        );
    }

    /**
     * Définit le contenu (la vue à utiliser)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation', // On va créer cette vue après
        );
    }
}