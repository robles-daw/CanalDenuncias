<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DenunciaAdjunto extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'denuncia_id',
        'nombre_original',
        'ruta_archivo',
        'mime_type',
        'tamano_bytes',
    ];

    /**
     * @return BelongsTo<Denuncia, $this>
     */
    public function denuncia(): BelongsTo
    {
        return $this->belongsTo(Denuncia::class);
    }
}
