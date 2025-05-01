<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipCrontroller extends Controller
{


    /**
    * Enviar una solicitud de amistad.
    */
    public function enviarSolicitudAmistad(User $user)
    {
        if (Auth::user()->id == $user->id) {
            return back()->with('error', 'No puedes enviarte una solicitud de amistad a ti mismo.');
        }

        // Verificar si ya existe una solicitud pendiente
        $existeSolicitud = Friendship::where(function($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('friend_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', Auth::id());
        })->where('status', 'pendiente')->exists();

        if ($existeSolicitud) {
            return back()->with('error', 'Ya has enviado una solicitud de amistad pendiente.');
        }

        // Crear solicitud de amistad
        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
            'status' => 'pendiente',
        ]);

        return back()->with('success', 'Solicitud de amistad enviada.');
    }

    /**
     * Aceptar una solicitud de amistad.
     */
    public function aceptarSolicitudAmistad(Friendship $friendship)
    {
        if ($friendship->friend_id != Auth::id()) {
            return back()->with('error', 'No puedes aceptar esta solicitud.');
        }

        $friendship->status = 'aceptada';
        $friendship->save();

        // Crear la relación inversa si aún no existe
        $existeRelacionInversa = Friendship::where('user_id', $friendship->friend_id)
            ->where('friend_id', $friendship->user_id)
            ->exists();

        if (!$existeRelacionInversa) {
            Friendship::create([
                'user_id' => $friendship->friend_id,
                'friend_id' => $friendship->user_id,
                'status' => 'aceptada',
            ]);
        }

        return back()->with('success', 'Solicitud de amistad aceptada.');
    }

    /**
     * Rechazar una solicitud de amistad.
     */
    public function rechazarSolicitudAmistad(Friendship $friendship)
    {
        if ($friendship->friend_id != Auth::id()) {
            return back()->with('error', 'No puedes rechazar esta solicitud.');
        }

        $friendship->status = 'rechazada';
        $friendship->save();

        return back()->with('success', 'Solicitud de amistad rechazada.');
    }

    /**
     * Mostrar los amigos aceptados de un usuario.
     */
    public function mostrarAmigos()
    {
        $amigos = Auth::user()->amigos; // Usamos la relación definida en el modelo User

        return view('amigos.index', compact('amigos'));
    }

    /**
     * Mostrar las solicitudes de amistad pendientes.
     */
    public function mostrarSolicitudesPendientes()
    {
        $solicitudesPendientes = Auth::user()->solicitudesRecibidas; // Usamos la relación definida en el modelo User

        return view('solicitudes.index', compact('solicitudesPendientes'));
    }

    /**
     * Eliminar un amigo aceptado.
     */
    public function eliminarAmigo(User $user)
    {
        $authId = Auth::id();

        // Eliminar ambas direcciones de amistad si existen
        Friendship::where(function($query) use ($authId, $user) {
            $query->where('user_id', $authId)
                ->where('friend_id', $user->id);
        })->orWhere(function($query) use ($authId, $user) {
            $query->where('user_id', $user->id)
                ->where('friend_id', $authId);
        })->where('status', 'aceptada')->delete();

        return back()->with('success', 'Amigo eliminado exitosamente.');
    }

}
