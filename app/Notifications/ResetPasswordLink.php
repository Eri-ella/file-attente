<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordLink extends Notification
{
    use Queueable;

    public function __construct(
        public string $url,
        public string $espace 
    ) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe - Smart Queue')
            ->greeting('Bonjour,')
            ->line("Vous recevez cet email car une demande de réinitialisation de mot de passe a été faite pour votre compte {$this->espace}.")
            ->action('Réinitialiser mon mot de passe', $this->url)
            ->line('Ce lien expirera dans 60 minutes.')
            ->line("Si vous n'êtes pas à l'origine de cette demande, ignorez simplement cet email.");
    }
}