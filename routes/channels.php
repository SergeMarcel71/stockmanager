<?php

use Illuminate\Support\Facades\Broadcast;

/**
 * Qui a le droit d'écouter le canal 'alertes-stock' ?
 * Seuls les utilisateurs qui ont la permission de voir les mouvements
 * (donc, d'après nos rôles v0.2 : admin, gestionnaire, employé — tout le monde connecté en pratique).
 * Si demain on veut restreindre aux seuls admin/gestionnaire, c'est ici qu'on change la règle.
 */
Broadcast::channel('alertes-stock', function ($user) {
    return $user->can('mouvements.voir');
});
