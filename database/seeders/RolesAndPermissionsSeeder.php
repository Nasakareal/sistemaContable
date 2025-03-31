<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Configuraciones y usuarios
            'ver configuraciones',
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Roles
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            // Fondos
            'ver fondos',
            'crear fondos',
            'editar fondos',
            'eliminar fondos',

            // Cuentas Bancarias
            'ver cuentas',
            'crear cuentas',
            'editar cuentas',
            'eliminar cuentas',

            // Capitulos
            'ver capitulos',
            'crear capitulos',
            'editar capitulos',
            'eliminar capitulos',

            // Partidas
            'ver partidas',
            'crear partidas',
            'editar partidas',
            'eliminar partidas',

            // Unidad Responsables
            'ver unidad',
            'crear unidad',
            'editar unidad',
            'eliminar unidad',

            // Areas
            'ver areas',
            'crear areas',
            'editar areas',
            'eliminar areas',

        ];

        // Crear permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Definición de roles y permisos asignados
        $roles = [
            'Administrador' => $permissions,
            'Subdirector' => [
                'ver configuraciones',
                'ver usuarios',
                'ver roles',
                'ver requisiciones',
                'crear requisiciones',
                'editar requisiciones',
                'eliminar requisiciones',
                'ver requisiciones por cuenta',
                'ver categorias',
                'crear categorias',
                'editar categorias',
                'eliminar categorias',
            ],
            'Empleado' => [
                'ver requisiciones',
                'ver requisiciones por cuenta',
                'ver productos',
                'ver proveedores',
            ],
            'Observador' => [
                'ver requisiciones',
                'ver productos',
            ],
        ];

        // Crear roles y asignar permisos
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Obtener permisos y sincronizarlos con el rol
            $permissionsToAssign = Permission::whereIn('name', $rolePermissions)->get();
            $role->syncPermissions($permissionsToAssign);
        }
    }
}
