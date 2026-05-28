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
        'color_inputs',
        'politica_privacidad_url',
        'politica_cookies_url',
        'aviso_legal_url',
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

    public function getColorPrincipalFormAccentAttribute(): string
    {
        return $this->formAccentFor($this->color_principal_hex);
    }

    public function getColorInputsHexAttribute(): string
    {
        return $this->color_inputs ?: $this->color_principal_form_accent;
    }

    public function getColorInputsSoftAttribute(): string
    {
        return $this->mixHex(
            $this->color_inputs_hex,
            $this->formAccentFor($this->color_inputs_hex),
            0.32,
        );
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

    protected function formAccentFor(string $hex): string
    {
        [$red, $green, $blue] = $this->hexToRgb($hex);
        $luminance = ((0.299 * $red) + (0.587 * $green) + (0.114 * $blue)) / 255;

        $darkenAmount = match (true) {
            $luminance >= 0.78 => 0.38,
            $luminance >= 0.65 => 0.30,
            $luminance >= 0.52 => 0.22,
            default => 0.14,
        };

        return $this->darkenHex($hex, $darkenAmount);
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

    protected function darkenHex(string $hex, float $amount): string
    {
        [$red, $green, $blue] = $this->hexToRgb($hex);

        return sprintf(
            '#%02x%02x%02x',
            (int) round($red * (1 - $amount)),
            (int) round($green * (1 - $amount)),
            (int) round($blue * (1 - $amount)),
        );
    }

    protected function mixHex(string $baseHex, string $targetHex, float $ratio): string
    {
        [$baseRed, $baseGreen, $baseBlue] = $this->hexToRgb($baseHex);
        [$targetRed, $targetGreen, $targetBlue] = $this->hexToRgb($targetHex);

        return sprintf(
            '#%02x%02x%02x',
            (int) round(($baseRed * (1 - $ratio)) + ($targetRed * $ratio)),
            (int) round(($baseGreen * (1 - $ratio)) + ($targetGreen * $ratio)),
            (int) round(($baseBlue * (1 - $ratio)) + ($targetBlue * $ratio)),
        );
    }
}
