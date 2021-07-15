<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Posts\PostService;
use App\Dao\Posts\PostDao;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    private $postService;


    protected function setUp():void
    {
        parent::setUp();
    
        $postDao = new PostDao();
        $this->postService = new PostService($postDao);
    }

    protected function tearDown():void
    {
        parent::tearDown();
    }

    public function testClassHasAttribute(){
        $attributeList = ['postDao'];

        foreach($attributeList as $attribute){
            $this->assertClassHasAttribute($attribute,PostService::class);
        }
    }

    public function testPostCreate(){
        //Post data
        $data = [
            'title' => 'Title',
            'description' => 'test',
        ];

        $response = $this->postService->storePost($data);
        dd($response);

        $response->assertStatus(200);
        //Assert we received a token
        $this->assertArrayHasKey('token',$response->json());
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetPostList()
    {
        $result = $this->postService->getPostList();

        $response = $this->get('/posts');

        $response->assertSee($result);
    }
}
