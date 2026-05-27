<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Denuncia extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'empresa_id',
        'causa_denuncia_id',
        'codigo_seguimiento',
        'estado',
        'gravedad',
        'descripcion_hechos',
        'fecha_hechos',
        'sigue_ocurriendo',
        'riesgo_inmediato',
        'anonima',
        'nombre_denunciante',
        'email_denunciante',
        'telefono_denunciante',
        'acepta_politica_privacidad',
        'declara_veracidad',
        'ip_origen',
        'user_agent',
        'metadatos',
        'fecha_recepcion',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_hechos' => 'date',
            'sigue_ocurriendo' => 'boolean',
            'riesgo_inmediato' => 'boolean',
            'anonima' => 'boolean',
            'acepta_politica_privacidad' => 'boolean',
            'declara_veracidad' => 'boolean',
            'metadatos' => 'array',
            'fecha_recepcion' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Empresa, $this>
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * @return BelongsTo<CausaDenuncia, $this>
     */
    public function causa(): BelongsTo
    {
        return $this->belongsTo(CausaDenuncia::class, 'causa_denuncia_id');
    }

    /**
     * @return HasMany<DenunciaImplicado, $this>
     */
    public function implicados(): HasMany
    {
        return $this->hasMany(DenunciaImplicado::class);
    }

    /**
     * @return HasMany<DenunciaAdjunto, $this>
     */
    public function adjuntos(): HasMany
    {
        return $this->hasMany(DenunciaAdjunto::class);
    }

    public function getEstadoLabelAttribute(): string
    {
        return match ($this->estado) {
            'en_revision' => 'En revisión',
            'pendiente' => 'Pendiente',
            'resuelta' => 'Resuelta',
            'archivada' => 'Archivada',
            default => Str::of((string) $this->estado)
                ->replace(['_', '-'], ' ')
                ->squish()
                ->title()
                ->value(),
        };
    }
}
