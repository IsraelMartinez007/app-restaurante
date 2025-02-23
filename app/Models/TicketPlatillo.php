<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPlatillo extends Model
{
    protected $fillable = ['ticket_id', 'platillo_id', 'cantidad', 'precio'];

    // Relación con el ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Relación con el platillo
    public function platillo()
    {
        return $this->belongsTo(Platillo::class);
    }
}
