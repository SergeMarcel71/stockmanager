<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Les 3 rôles du Module A du cahier des charges
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $gestionnaire = Role::firstOrCreate(['name' => 'gestionnaire']);
        $employe = Role::firstOrCreate(['name' => 'employe']);

        $permissions = [
            'produits.voir',
            'produits.gerer',       // créer/modifier/supprimer
            'mouvements.voir',
            'mouvements.creer',
            'fournisseurs.gerer',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin : tout
        $admin->syncPermissions($permissions);

        // Gestionnaire : tout sauf rien en plus pour l'instant (identique à admin en v0.2,
        // la distinction fine viendra avec la gestion des utilisateurs en v0.3/v1.0)
        $gestionnaire->syncPermissions([
            'produits.voir',
            'produits.gerer',
            'mouvements.voir',
            'mouvements.creer',
            'fournisseurs.gerer',
        ]);

        // Employé : lecture + peut déclarer une sortie, ne peut pas gérer les produits/fournisseurs
        $employe->syncPermissions([
            'produits.voir',
            'mouvements.voir',
            'mouvements.creer',
        ]);
    }
}
