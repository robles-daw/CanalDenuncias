<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'slug',
        'email_canal_denuncias',
        'telefono_canal_denuncias',
        'dominio',
        'logo',
        'pdf',
        'pdf_normativa',
        'color_principal',
        'color_secundario',
        'activa',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'activa' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function getColorPrincipalHexAttribute(): string
    {
        return $this->color_principal ?: '#b24a1b';
    }

    public function getColorSecundarioHexAttribute(): string
    {
        return $this->color_secundario ?: '#8e3710';
    }

    public function getColorPrincipalContrastAttribute(): string
    {
        return $this->contrastTextFor($this->color_principal_hex);
    }

    public function getColorSecundarioContrastAttribute(): string
    {
        return $this->contrastTextFor($this->color_secundario_hex);
    }

    public function getBrandContrastAttribute(): string
    {
        $primaryRgb = $this->hexToRgb($this->color_principal_hex);
        $secondaryRgb = $this->hexToRgb($this->color_secundario_hex);

        $mixedHex = sprintf(
            '#%02x%02x%02x',
            (int) round(($primaryRgb[0] + $secondaryRgb[0]) / 2),
            (int) round(($primaryRgb[1] + $secondaryRgb[1]) / 2),
            (int) round(($primaryRgb[2] + $secondaryRgb[2]) / 2),
        );

        return $this->contrastTextFor($mixedHex);
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo) {
            return null;
        }

        if (str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }

        if (str_starts_with($this->logo, 'uploads/') || str_starts_with($this->logo, 'default-')) {
            return asset($this->logo);
        }

        return asset('storage/'.$this->logo);
    }

    public function getNormativaUrlAttribute(): ?string
    {
        $path = $this->pdf_normativa ?: $this->pdf;

        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }

    public function getRouteKeyName(): string
    {
        return 'dominio';
    }

    /**
     * @return HasMany<Denuncia, $this>
     */
    public function denuncias(): HasMany
    {
        return $this->hasMany(Denuncia::class);
    }

    protected function contrastTextFor(string $hex): string
    {
        [$red, $green, $blue] = $this->hexToRgb($hex);
        $luminance = ((0.299 * $red) + (0.587 * $green) + (0.114 * $blue)) / 255;

        return $luminance > 0.6 ? '#15202b' : '#ffffff';
    }

    /**
     * @return array{0:int,1:int,2:int}
     */
    protected function hexToRgb(string $hex): array
    {
        $normalized = ltrim($hex, '#');

        if (strlen($normalized) === 3) {
            $normalized = preg_replace('/(.)/', '$1$1', $normalized) ?: '000000';
        }

        return [
            hexdec(substr($normalized, 0, 2)),
            hexdec(substr($normalized, 2, 2)),
            hexdec(substr($normalized, 4, 2)),
        ];
    }
}
