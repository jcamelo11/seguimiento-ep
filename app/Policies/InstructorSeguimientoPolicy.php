<?php

namespace App\Policies;

use App\Models\User;
use App\Models\InstructorSeguimiento;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstructorSeguimientoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_instructor::seguimiento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InstructorSeguimiento $instructorSeguimiento): bool
    {
        return $user->can('view_instructor::seguimiento');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_instructor::seguimiento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InstructorSeguimiento $instructorSeguimiento): bool
    {
        return $user->can('update_instructor::seguimiento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InstructorSeguimiento $instructorSeguimiento): bool
    {
        return $user->can('delete_instructor::seguimiento');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_instructor::seguimiento');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, InstructorSeguimiento $instructorSeguimiento): bool
    {
        return $user->can('force_delete_instructor::seguimiento');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_instructor::seguimiento');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, InstructorSeguimiento $instructorSeguimiento): bool
    {
        return $user->can('restore_instructor::seguimiento');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_instructor::seguimiento');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, InstructorSeguimiento $instructorSeguimiento): bool
    {
        return $user->can('replicate_instructor::seguimiento');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_instructor::seguimiento');
    }

    
}
