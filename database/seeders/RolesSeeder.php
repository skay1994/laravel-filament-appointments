<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $app = app(Role::class);

        array_map(static fn(RolesEnum $role) => $app::findOrCreate($role->value, $role->guard()), RolesEnum::cases());
    }
}
