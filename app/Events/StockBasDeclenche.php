<?php

namespace App\Events;

use App\Models\Produit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockBasDeclenche implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Produit $produit)
    {
    }

    /**
     * Le "canal" est comme une fréquence radio : tous les navigateurs connectés
     * et abonnés à ce canal reçoivent l'événement en direct, sans recharger la page.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('alertes-stock'),
        ];
    }

    /**
     * Nom de l'événement tel que reçu côté navigateur (JS).
     * Sans ça, Laravel utiliserait le nom complet de la classe PHP, peu pratique en JS.
     */
    public function broadcastAs(): string
    {
        return 'stock.bas';
    }

    /**
     * Ce qu'on envoie réellement au navigateur — on choisit nous-mêmes les champs,
     * pas besoin d'exposer tout le modèle Eloquent.
     */
    public function broadcastWith(): array
    {
        return [
            'produit_id' => $this->produit->id,
            'nom' => $this->produit->nom,
            'quantite_stock' => $this->produit->quantite_stock,
            'seuil_alerte' => $this->produit->seuil_alerte,
        ];
    }
}
