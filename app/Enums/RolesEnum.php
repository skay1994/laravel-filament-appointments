<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
        };
    }

    public function guard(): string
    {
        return match ($this) {
            self::ADMIN => 'web',
        };
    }
}
