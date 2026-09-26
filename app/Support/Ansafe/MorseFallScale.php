<?php

namespace App\Support\Ansafe;

use App\Enums\Ansafe\FallRiskCategory;

final class MorseFallScale
{
    /**
     * Morse Fall Scale dimensions and selectable options (value => points).
     *
     * @return list<array{key: string, label: string, options: list<array{value: string, label: string, points: int}>}>
     */
    public static function dimensions(): array
    {
        return [
            [
                'key' => 'history_of_falling',
                'label' => 'Riwayat jatuh',
                'options' => [
                    ['value' => 'no', 'label' => 'Tidak (0)', 'points' => 0],
                    ['value' => 'yes', 'label' => 'Ya (25)', 'points' => 25],
                ],
            ],
            [
                'key' => 'secondary_diagnosis',
                'label' => 'Diagnosis sekunder',
                'options' => [
                    ['value' => 'no', 'label' => 'Tidak (0)', 'points' => 0],
                    ['value' => 'yes', 'label' => 'Ya (15)', 'points' => 15],
                ],
            ],
            [
                'key' => 'ambulatory_aid',
                'label' => 'Alat bantu berjalan',
                'options' => [
                    ['value' => 'none', 'label' => 'Tidak ada / bed rest (0)', 'points' => 0],
                    ['value' => 'crutch', 'label' => 'Kruk / tongkat / walker (15)', 'points' => 15],
                    ['value' => 'furniture', 'label' => 'Berpegangan furniture (30)', 'points' => 30],
                ],
            ],
            [
                'key' => 'iv_therapy',
                'label' => 'Terapi IV / heparin lock',
                'options' => [
                    ['value' => 'no', 'label' => 'Tidak (0)', 'points' => 0],
                    ['value' => 'yes', 'label' => 'Ya (20)', 'points' => 20],
                ],
            ],
            [
                'key' => 'gait',
                'label' => 'Gaya berjalan',
                'options' => [
                    ['value' => 'normal', 'label' => 'Normal / bed rest (0)', 'points' => 0],
                    ['value' => 'weak', 'label' => 'Lemah (10)', 'points' => 10],
                    ['value' => 'impaired', 'label' => 'Terganggu (20)', 'points' => 20],
                ],
            ],
            [
                'key' => 'mental_status',
                'label' => 'Status mental',
                'options' => [
                    ['value' => 'oriented', 'label' => 'Menyadari kemampuan sendiri (0)', 'points' => 0],
                    ['value' => 'forgets', 'label' => 'Lupa keterbatasan (15)', 'points' => 15],
                ],
            ],
        ];
    }

    /**
     * @param  array<string, int>  $pointsByDimension
     */
    public static function total(array $pointsByDimension): int
    {
        return (int) array_sum($pointsByDimension);
    }

    public static function category(int $total): FallRiskCategory
    {
        if ($total <= 24) {
            return FallRiskCategory::Rendah;
        }

        if ($total <= 44) {
            return FallRiskCategory::Sedang;
        }

        return FallRiskCategory::Tinggi;
    }

    /**
     * @return array<string, int>
     */
    public static function pointsForSelections(array $selections): array
    {
        $points = [];

        foreach (self::dimensions() as $dimension) {
            $key = $dimension['key'];
            $selected = $selections[$key] ?? null;
            $points[$key] = 0;

            foreach ($dimension['options'] as $option) {
                if ($option['value'] === $selected) {
                    $points[$key] = $option['points'];
                    break;
                }
            }
        }

        return $points;
    }

    public static function protocolMessage(FallRiskCategory $category): string
    {
        return match ($category) {
            FallRiskCategory::Rendah => 'Pasien termasuk kategori risiko jatuh rendah. Lanjutkan observasi rutin sesuai protokol.',
            FallRiskCategory::Sedang => 'Pasien termasuk kategori risiko jatuh sedang. Terapkan intervensi pencegahan standar.',
            FallRiskCategory::Tinggi => 'Pasien termasuk dalam kategori risiko jatuh tinggi. Lakukan intervensi pencegahan sesuai protokol.',
        };
    }
}
