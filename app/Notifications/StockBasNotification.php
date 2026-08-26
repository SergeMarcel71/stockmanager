<?php

namespace App\Notifications;

use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StockBasNotification extends Notification
{
    use Queueable;

    public function __construct(public Produit $produit)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("⚠️ Stock bas : {$this->produit->nom}")
            ->line("Le produit « {$this->produit->nom} » (SKU: {$this->produit->sku}) est passé sous son seuil d'alerte.")
            ->line("Quantité actuelle : {$this->produit->quantite_stock}")
            ->line("Seuil d'alerte : {$this->produit->seuil_alerte}")
            ->action('Voir le produit', route('produits.edit', $this->produit))
            ->line('Pensez à passer commande auprès du fournisseur si nécessaire.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'produit_id' => $this->produit->id,
            'nom' => $this->produit->nom,
            'quantite_stock' => $this->produit->quantite_stock,
            'seuil_alerte' => $this->produit->seuil_alerte,
        ];
    }
}
