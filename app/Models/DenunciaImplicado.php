<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DenunciaImplicado extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'denuncia_id',
        'nombre',
        'cargo',
        'descripcion',
        'orden',
    ];

    /**
     * @return BelongsTo<Denuncia, $this>
     */
    public function denuncia(): BelongsTo
    {
        return $this->belongsTo(Denuncia::class);
    }
}
