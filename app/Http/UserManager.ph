<?php
use App\Models\User;
use App\Models\Role;


    class UserManager {
        public static function obtenerUsuariosPorRol($rol)
        {
            // Obtener todos los usuarios que tienen un rol específico
            return User::whereHas('roles', function ($query) use ($rol) {
                $query->where('name', $rol);
            })->get();
        }

        public static function esUsuarioDeRol(User $usuario, $rol)
        {
            // Verificar si el usuario tiene un rol específico
            return $usuario->hasRole($rol);
        }

        public static function asignarRolAUsuario(User $usuario, $rol)
        {
            // Asignar un rol específico al usuario
            $usuario->roles()->attach(Role::where('name', $rol)->first());
        }
    }
