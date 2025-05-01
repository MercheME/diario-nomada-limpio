<?php

namespace App\Policies;

use App\Models\DiarioImagen;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiarioImagenPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DiarioImagen $diarioImagen): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DiarioImagen $diarioImagen): bool
    {
        return $user->id === $diarioImagen->user_id;
    }

    public function setAsPrincipal(User $user, DiarioImagen $imagen)
    {
        return $user->id === $imagen->diario->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DiarioImagen $imagen): bool
    {
        return $user->id === $imagen->diario->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DiarioImagen $diarioImagen): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DiarioImagen $diarioImagen): bool
    {
        return false;
    }
}
