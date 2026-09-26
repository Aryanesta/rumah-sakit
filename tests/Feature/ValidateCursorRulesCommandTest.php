<?php

namespace Tests\Feature;

use Tests\TestCase;

class ValidateCursorRulesCommandTest extends TestCase
{
    public function test_cursor_rules_pass_validation(): void
    {
        $this->artisan('rules:validate-cursor')
            ->assertSuccessful();
    }
}
