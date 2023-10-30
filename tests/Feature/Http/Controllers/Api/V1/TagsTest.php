<?php

namespace Tests\Feature\Http\Controllers\Api\V1;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tag;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TagsTest extends TestCase
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
        $tags=Tag::factory(2)->create();
        $response=$this->getJson('/api/v1/tags');
        $response->assertStatus(Response::HTTP_OK)
       
        ->assertJsonCount(2,'data')
              ->assertJsonStructure([
                'data'=>[
                    [
                    'id',
                    'type',
                    'atributes'=>['name'],
                    'relationships'=>[
                        'recipes'=>[]
                    ],

                    
                ] 
                ]
            ]);
    }
    public function test_show()
    {      
   
        Sanctum::actingAs(User::factory()->create());
        $tag=Tag::factory()->create();
        $response=$this->getJson('/api/v1/tags/'. $tag->id);
        $response->assertStatus(Response::HTTP_OK)
              ->assertJsonStructure([
                'data'=>[
                    'id',
                    'type',
                    'atributes'=>['name'],
                     'relationships' =>[
                        'recipes'=>[]
                     ],
                ] 
            
            ]);
    }
}
