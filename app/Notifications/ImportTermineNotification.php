<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportTermineNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $crees,
        public int $misAJour,
        public array $erreurs
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Import de produits terminé')
            ->line("{$this->crees} produit(s) créé(s), {$this->misAJour} mis à jour.");

        if (! empty($this->erreurs)) {
            $message->line('Quelques lignes ont été ignorées :');
            foreach (array_slice($this->erreurs, 0, 10) as $erreur) {
                $message->line("• {$erreur}");
            }
        }

        return $message->action('Voir l\'inventaire', route('produits.index'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'crees' => $this->crees,
            'mis_a_jour' => $this->misAJour,
            'erreurs' => $this->erreurs,
        ];
    }
}
