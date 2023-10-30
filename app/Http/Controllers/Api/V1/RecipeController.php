<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use  App\Http\Resources\TagResource;
use Symfony\Component\HttpFoundation\Response;
use  App\Http\Resources\RecipeResource;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Policies\RecipePoliticy;    
class RecipeController extends Controller
{
    public function index(){
                $recipes = Recipe::with('category','tags','user')->get();
        return 
        RecipeResource::collection($recipes);
    }


    public function store(StoreRecipeRequest $request) 
    {
        $recipe = $request->user()->recipes()->create($request->all());
        $recipe->tags()->attach(json_decode($request->tags));

        $recipe->image = $request->file('image')->store('recipes', 'public');
        $recipe->save();

        return response()->json(new RecipeResource($recipe), Response::HTTP_CREATED); // HTTP 201
    }

    public function show( Recipe $recipe){
     $recipe->load('category','tags','user');
        return new RecipeResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe) {
        $this->authorize('update', $recipe);
    
        $data = $request->all(); // Obtener todos los datos enviados
    
        // Actualizar cada campo si está presente en la solicitud
        if ($request->has('category_id')) {
            $recipe->category_id = $request->input('category_id');
        }
    
        if ($request->has('title')) {
            $recipe->title = $request->input('title');
        }
    
        if ($request->has('description')) {
            $recipe->description = $request->input('description');
        }
    
        if ($request->has('ingredients')) {
            $recipe->ingredients = $request->input('ingredients');
        }
    
        if ($request->has('instructions')) {
            $recipe->instructions = $request->input('instructions');
        }
    
        // Actualizar la imagen si se envía en la solicitud
        if ($request->hasFile('image')) {
            $recipe->image = $request->file('image')->store('recipes', 'public');
        }
    
        // Guardar la receta
        $recipe->save();
    
        // Resto del código para manejar las tags, etc.
    
        return response()->json(new RecipeResource($recipe), Response::HTTP_OK);
    }
    

    public  function destroy(Recipe $recipe) { 
        $this->authorize('delete', $recipe);

        $recipe->delete();
        return  response()->json(null, Response::HTTP_NO_CONTENT);
     }
}
