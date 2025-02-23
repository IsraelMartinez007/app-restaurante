<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $fillable = ['establecimiento_id', 'mesa_id', 'total', 'fecha'];
    protected $with = ["platillos"];

    // Relación con los platillos
    public function platillos()
    {
        return $this->belongsToMany(Platillo::class, 'ticket_platillos')
                    ->withPivot('cantidad', 'precio');
    }

    // Relación con la mesa (si aplica)
    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}
