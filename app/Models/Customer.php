<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes, HasFactory, HasUuids;

    protected $fillable = [
        'name', 'last_name', 'email', 'phone', 'document',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected function document(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => preg_replace('/\D/', '', $value),
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => preg_replace('/\D/', '', $value),
        );
    }

    public function getDocumentWithMaskAttribute(): string
    {
        if(strlen($this->document) > 11) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $this->document);
        }

        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->document);
    }

    public function getPhoneWithMaskAttribute(): string
    {
        return preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $this->phone);
    }
}
