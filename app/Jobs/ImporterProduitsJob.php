<?php

namespace App\Jobs;

use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\User;
use App\Notifications\ImportTermineNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImporterProduitsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param string $cheminFichier Chemin relatif dans le disque "local" (storage/app)
     */
    public function __construct(
        private string $cheminFichier,
        private int $utilisateurId
    ) {
    }

    public function handle(): void
    {
        $chemin = Storage::path($this->cheminFichier);
        $handle = fopen($chemin, 'r');

        // On saute la ligne d'en-tête : nom,sku,prix_unitaire,quantite_stock,seuil_alerte,categorie,fournisseur
        $entete = fgetcsv($handle);

        $crees = 0;
        $misAJour = 0;
        $erreurs = [];
        $ligne = 1;

        while (($donnees = fgetcsv($handle)) !== false) {
            $ligne++;

            try {
                [$nom, $sku, $prix, $quantite, $seuil, $nomCategorie, $nomFournisseur] = array_pad($donnees, 7, null);

                if (empty($nom) || empty($sku)) {
                    $erreurs[] = "Ligne {$ligne} : nom ou SKU manquant, ignorée.";
                    continue;
                }

                $categorieId = $nomCategorie
                    ? Categorie::firstOrCreate(['nom' => trim($nomCategorie)])->id
                    : null;

                $fournisseurId = $nomFournisseur
                    ? Fournisseur::firstOrCreate(['nom' => trim($nomFournisseur)])->id
                    : null;

                $produit = Produit::updateOrCreate(
                    ['sku' => trim($sku)],
                    [
                        'nom' => trim($nom),
                        'prix_unitaire' => (float) $prix,
                        'quantite_stock' => (int) $quantite,
                        'seuil_alerte' => $seuil !== null ? (int) $seuil : 5,
                        'categorie_id' => $categorieId,
                        'fournisseur_id' => $fournisseurId,
                    ]
                );

                $produit->wasRecentlyCreated ? $crees++ : $misAJour++;
            } catch (\Throwable $e) {
                $erreurs[] = "Ligne {$ligne} : erreur — " . $e->getMessage();
            }
        }

        fclose($handle);
        Storage::delete($this->cheminFichier);

        $utilisateur = User::find($this->utilisateurId);
        if ($utilisateur) {
            $utilisateur->notify(new ImportTermineNotification($crees, $misAJour, $erreurs));
        }
    }
}
