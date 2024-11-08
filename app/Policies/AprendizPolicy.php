<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Aprendiz;
use Illuminate\Auth\Access\HandlesAuthorization;

class AprendizPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_aprendiz');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Aprendiz $aprendiz): bool
    {
        return $user->can('view_aprendiz');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_aprendiz');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Aprendiz $aprendiz): bool
    {
        return $user->can('update_aprendiz');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Aprendiz $aprendiz): bool
    {
        return $user->can('delete_aprendiz');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_aprendiz');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Aprendiz $aprendiz): bool
    {
        return $user->can('force_delete_aprendiz');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_aprendiz');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Aprendiz $aprendiz): bool
    {
        return $user->can('restore_aprendiz');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_aprendiz');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Aprendiz $aprendiz): bool
    {
        return $user->can('replicate_aprendiz');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_aprendiz');
    }

    public function exportar(User $user) 
    {
        return $user->can('exportar_aprendiz'); 
    } 

    public function importar(User $user) { 
        return $user->can('importar_aprendiz'); 
    } 
    
    public function generarInformes(User $user) 
    { 
        return $user->can('generar_informes_aprendiz'); 
    } 
    
    public function generarAval(User $user) 
    { 
        return $user->can('generar_aval_aprendiz');
    }

    public function verAprendicesAsignados(User $user) 
    { 
        return $user->can('ver_aprendices_asignados');
    }

    public function filtarInstructor(User $user) 
    { 
        return $user->can('filtar_instructor');
    }
}
