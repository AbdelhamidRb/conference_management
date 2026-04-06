<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserConference extends Model
{
    // Désactive l'auto-incrémentation
    public $incrementing = false;

    // Il n'est pas possible de spécifier plusieurs colonnes directement comme clé primaire,
    // mais vous pouvez créer des requêtes personnalisées ou gérer la logique dans les méthodes.
    protected $primaryKey = 'conference_id';  // Utiliser une colonne de votre choix pour une clé primaire principale

    // Vous pouvez définir d'autres colonnes comme clés de recherche dans les requêtes
    protected $guarded = [];

    // Personnaliser les requêtes de sauvegarde avec une clé composite
    public function setKeysForSaveQuery($query)
    {
        return $query->where('conference_id', $this->conference_id)
            ->where('user_id', $this->user_id)
            ->where('role', $this->role);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
