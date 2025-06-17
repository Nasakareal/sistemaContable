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

             // Solicitudes Dev
            'ver solicitudesDev',
            'crear solicitudesDev',
            'editar solicitudesDev',
            'eliminar solicitudesDev',

            // Evidencias
            'ver evidencias',
            'crear evidencias',
            'editar evidencias',
            'eliminar evidencias',

            // Transacciones
            'ver transacciones',
            'crear transacciones',
            'editar transacciones',
            'eliminar transacciones',

            // Reportes
            'ver reportes',
            'crear reportes',
            'editar reportes',
            'eliminar reportes',

            // Ministraciones
            'ver ministraciones',
            'crear ministraciones',
            'editar ministraciones',
            'eliminar ministraciones',

            // Asignación Presupuestal
            'ver asignacionpresupuestal',
            'crear asignacionpresupuestal',
            'editar asignacionpresupuestal',
            'eliminar asignacionpresupuestal',

            // Movimientos
            'ver movimientos',
            'crear movimientos',
            'editar movimientos',
            'eliminar movimientos',

            // Estadisticas
            'ver estadisticas',
            'crear estadisticas',
            'editar estadisticas',
            'eliminar estadisticas',

            // Proyecciones
            'ver proyecciones',
            'crear proyecciones',
            'editar proyecciones',
            'eliminar proyecciones',

            // Viaticos
            'ver viaticos',
            'crear viaticos',
            'editar viaticos',
            'eliminar viaticos',

        ];

        // Crear permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Definición de roles y permisos asignados
        $roles = [
            'Administrador' => $permissions,
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
