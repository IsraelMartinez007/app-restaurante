<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

// modelos
use App\Models\Establecimiento;
use App\Models\Mesa;
use App\Models\Platillo;
use App\Models\Ticket;
use App\Models\TicketPlatillo;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // obteniendo la primer sucursal
        $establecimiento_actual = session("establecimiento_actual");
        
        if(!$establecimiento_actual){
            $establecimiento_actual = Establecimiento::first()->id;
        }

        // obtengo la lista de las mesas que sean de la sucursal actual
        $mesas = Mesa::where("establecimiento_id",$establecimiento_actual)->where("disponible","1")->get();

        $reservaciones = Mesa::where("establecimiento_id",$establecimiento_actual)->where("disponible","0")->get();

        $pĺatillos = Platillo::all();
        
        
        return Inertia::render('Dashboard',[
            "establecimiento_actual" => Establecimiento::find($establecimiento_actual),
            "establecimientos"=>Establecimiento::all(),
            "mesas"=>$mesas,
            "reservaciones"=>$reservaciones,
            "platillos"=>$pĺatillos,
            "tickets"=>Ticket::all()
        ]);
    }
    
    public function update($id){
        session(["establecimiento_actual"=>$id]);
        
    }

    public function reservar(Request $requets){
        $mesa = Mesa::find($requets->id);
        $mesa->comensal = $requets->comensal;
        $mesa->disponible = 0;
        $mesa->save();
    }

    public function cancelar_reservacion(Request $requets){
        $mesa = Mesa::find($requets->id);
        $mesa->comensal = "";
        $mesa->disponible = 1;
        $mesa->save();
    }

    public function procesarVenta(Request $request)
{
    // Obtener el establecimiento asociado a la mesa
    $mesa = Mesa::find($request->mesa);
    $establecimiento_id = $mesa->establecimiento_id;

    // Crear el ticket, incluyendo el establecimiento_id
    $ticket = Ticket::create([
        'mesa_id' => $request->mesa,
        'total' => $request->total,
        'estado' => 'pagado',
        'establecimiento_id' => $establecimiento_id, // Añadir el establecimiento_id
    ]);

    // Asociar los platillos con el ticket
    foreach ($request->carrito as $item) {
        TicketPlatillo::create([
            'ticket_id' => $ticket->id,
            'platillo_id' => $item['id'],
            'cantidad' => $item['cantidad'],
            'precio' => $item['precio'],
            'subtotal' => $item['precio']*$item['cantidad'],
        ]);
    }

    // Actualizar la mesa a disponible
    $mesa->disponible = true;
    $mesa->comensal = ""; // Limpiar el nombre del comensal
    $mesa->save();

    return response()->json(['message' => 'Venta procesada exitosamente', 'ticket' => $ticket]);
}
}
