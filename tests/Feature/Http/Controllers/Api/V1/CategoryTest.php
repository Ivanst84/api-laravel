<?php

namespace Tests\Feature\Http\Controllers\Api\V1;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     use RefreshDatabase;
    public function test_index()
    {

        Sanctum::actingAs(User::factory()->create());
        $categories=Category::factory(2)->create();
        $response=$this->getJson('/api/v1/categories');
        $response->assertJsonCount(2,'data')
              ->assertJsonStructure([
                'data'=>[[
                    'id',
                    'type',
                    'atributes'=>['name'],
                    ]
                ] 
            ]);
    }
    public function test_show()
    {      
   
        Sanctum::actingAs(User::factory()->create());
        $category=Category::factory()->create();
        $response=$this->getJson('/api/v1/categories/'.$category->id);
        $response->assertStatus(Response::HTTP_OK)
              ->assertJsonStructure([
                'data'=>[
                    'id',
                    'type',
                    'atributes'=>['name'],

                ] 
            
            ]);
    }
}
