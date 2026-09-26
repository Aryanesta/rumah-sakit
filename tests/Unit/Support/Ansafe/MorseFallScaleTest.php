<?php

namespace Tests\Unit\Support\Ansafe;

use App\Enums\Ansafe\FallRiskCategory;
use App\Support\Ansafe\MorseFallScale;
use PHPUnit\Framework\TestCase;

class MorseFallScaleTest extends TestCase
{
    public function test_category_boundaries(): void
    {
        $this->assertSame(FallRiskCategory::Rendah, MorseFallScale::category(24));
        $this->assertSame(FallRiskCategory::Sedang, MorseFallScale::category(25));
        $this->assertSame(FallRiskCategory::Sedang, MorseFallScale::category(44));
        $this->assertSame(FallRiskCategory::Tinggi, MorseFallScale::category(45));
    }

    public function test_total_sums_dimension_points(): void
    {
        $points = [
            'history_of_falling' => 25,
            'secondary_diagnosis' => 0,
            'ambulatory_aid' => 15,
            'iv_therapy' => 0,
            'gait' => 20,
            'mental_status' => 0,
        ];

        $this->assertSame(60, MorseFallScale::total($points));
    }

    public function test_demo_patient_budi_scores_fifty_five(): void
    {
        $selections = [
            'history_of_falling' => 'yes',
            'secondary_diagnosis' => 'no',
            'ambulatory_aid' => 'furniture',
            'iv_therapy' => 'no',
            'gait' => 'normal',
            'mental_status' => 'oriented',
        ];

        $total = MorseFallScale::total(MorseFallScale::pointsForSelections($selections));

        $this->assertSame(55, $total);
    }
}
