<?php

namespace Tests\Feature;

use Tests\TestCase;

class Base extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @param $response
     * @return void
     */
    public function assertAll($response)
    {
        $response->assertJsonStructure([
            'data',
            'message',
            'status'
        ]);
        $response->assertStatus(200)
            ->assertJson([
                "status" => true,
            ]);
    }

}
