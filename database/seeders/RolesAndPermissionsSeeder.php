<?php
// database/seeders/RolesAndPermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 🔄 Limpieza previa de caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 🔹 Crear permisos
        $permissions = [
            'ver dashboard',

            'ver usuarios',
            'crear usuario',
            'editar usuario',
            'eliminar usuario',

            'ver roles',
            'crear rol',
            'editar rol',
            'eliminar rol',

            'ver permisos',
            'crear permiso',
            'editar permiso',
            'eliminar permiso',

            'gestionar usuarios',
            'gestionar roles',
            'gestionar permisos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        // 🔹 Crear roles
        $admin = Role::firstOrCreate(['name' => 'Administrador'], ['guard_name' => 'web']);
        $contador = Role::firstOrCreate(['name' => 'Contador'], ['guard_name' => 'web']);
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor'], ['guard_name' => 'web']);

        // 🔹 Asignar permisos a roles
        $admin->syncPermissions(Permission::all());

        $contador->syncPermissions([
            'ver dashboard',
            'ver usuarios',
        ]);

        $supervisor->syncPermissions([
            'ver dashboard',
            'ver usuarios',
            'editar usuario',
        ]);

        // 🔹 Usuario Administrador
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrador General',
                'password' => bcrypt('12345678'),
            ]
        );
        $userAdmin->syncRoles('Administrador');

        // 🔹 Usuario Contador
        $userContador = User::firstOrCreate(
            ['email' => 'contador@gmail.com'],
            [
                'name' => 'Usuario Contador',
                'password' => bcrypt('12345678'),
            ]
        );
        $userContador->syncRoles('Contador');

        // 🔹 USUARIOS ADICIONALES (TODOS SUPERVISOR)
        $usuariosSupervisor = [
            [
                'email' => 'bhchierro.consorcio@gmail.com',
                'name' => 'Alexandra Apaza Cusi',
                'password' => '74128823',
            ],
            [
                'email' => 'mbacap@bhcardenasperu.com',
                'name' => 'Michael Baca Pacheco',
                'password' => '70097776',
            ],
            [
                'email' => 'axbacap@bhcardenasperu.com',
                'name' => 'Axel Fabricio Baca Pacheco',
                'password' => '71456903',
            ],
            [
                'email' => 'yneiraa@bhcardenasperu.com',
                'name' => 'Yesenia Maria Neira Arenas',
                'password' => '40029835',
            ],
            [
                'email' => 'contabilidad@bhcardenasperu.com',
                'name' => 'Alicia Cati Condori Ari',
                'password' => '74128848',
            ],
        ];

        foreach ($usuariosSupervisor as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt($data['password']),
                ]
            );

            $user->syncRoles('Supervisor');
        }
    }
}
