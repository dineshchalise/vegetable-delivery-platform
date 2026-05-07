<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_endpoint_requires_authentication(): void
    {
        $this->getJson('/api/admin/dashboard/stats')->assertUnauthorized();
    }
}
