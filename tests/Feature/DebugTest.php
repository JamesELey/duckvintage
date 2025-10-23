<?php

namespace Tests\Feature;

use Tests\TestCase;

class DebugTest extends TestCase
{
    /** @test */
    public function debug_home_page_error()
    {
        $response = $this->get('/');
        
        if ($response->status() !== 200) {
            echo "Status: " . $response->status() . "\n";
            echo "Content: " . $response->content() . "\n";
        }
        
        $response->assertStatus(200);
    }
}
