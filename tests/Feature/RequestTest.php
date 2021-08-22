<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

class RequestTest extends TestCase
{

    public function testHeader()
    {

        $response = $this->call('POST', '/api/test', [], [], [], ['HTTP_User_Id' => 'content'], []);
        $foo = $response->getContent();
        // dd($foo);
        $this->assertEquals('yes', $foo);
    }
}
