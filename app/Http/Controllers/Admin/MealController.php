<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealModel;
use App\Models\DietTypeModel;
use App\Models\MealTypeModel;
use App\Models\TagModel;
use App\Models\AllergenModel;
use App\Models\IngredientModel;
use App\Models\RecipeIngredientModel;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(Request $request)
    {
        // Get search parameter
        $search = $request->get('search');

        // Build query with relationships
        $query = MealModel::with(['dietType', 'mealType', 'tags', 'recipeIngredients.ingredient']);

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('id', $search);
        }

        // Get paginated results
        $meals = $query->orderBy('created_at', 'desc')->paginate(10);

        // Preserve search in pagination links
        $meals->appends(['search' => $search]);

        // Calculate statistics
        $totalMeals = MealModel::count();
        $activeMeals = MealModel::whereNull('deleted_at')->count();
        $usageRate = $totalMeals > 0 ? round(($activeMeals / $totalMeals) * 100) : 0;

        return view('admin.meals.index', [
            'meals' => $meals,
            'search' => $search,
            'totalMeals' => $totalMeals,
            'activeMeals' => $activeMeals,
            'usageRate' => $usageRate . '%'
        ]);
    }

    public function create()
    {
        return view('admin.meals.form-main', [
            'meal' => null,
            'dietTypes' => DietTypeModel::all(),
            'mealTypes' => MealTypeModel::all(),
            'tags' => TagModel::all(),
            'allergens' => AllergenModel::all(),
            'ingredients' => IngredientModel::all()
        ]);
    }

    public function edit($id)
    {
        $meal = MealModel::with([
            'dietType',
            'mealType',
            'tags',
            'allergens',
            'recipeIngredients.ingredient'
        ])->findOrFail($id);

        return view('admin.meals.form-main', [
            'meal' => $meal,
            'dietTypes' => DietTypeModel::all(),
            'mealTypes' => MealTypeModel::all(),
            'tags' => TagModel::all(),
            'allergens' => AllergenModel::all(),
            'ingredients' => IngredientModel::all()
        ]);
    }

    public function save(Request $request)
    {
        // Basic validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'diet_type_id' => 'required|exists:diet_type,id',
            'meal_type_id' => 'required|exists:meal_type,id',
            'preparation' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $id = $request->input('id');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/meals'), $imageName);
            $validatedData['image_url'] = $imageName;
        }

        if ($id) {
            // Update existing meal
            $meal = MealModel::findOrFail($id);

            // Delete old image if new image is uploaded
            if (isset($validatedData['image_url']) && $meal->image_url) {
                $oldImagePath = public_path('uploads/meals/' . $meal->image_url);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $meal->update($validatedData);

            // Update tags
            if ($request->has('tags')) {
                $meal->tags()->sync($request->input('tags'));
            } else {
                $meal->tags()->sync([]);
            }

            // Update allergens
            if ($request->has('allergens')) {
                $meal->allergens()->sync($request->input('allergens'));
            } else {
                $meal->allergens()->sync([]);
            }

            // Update recipe ingredients
            $this->updateRecipeIngredients($meal, $request->input('ingredients', []));

            return redirect()->route('meals.index')->with('success', 'Đã cập nhật món ăn thành công.');
        } else {
            // Create new meal
            $meal = MealModel::create($validatedData);

            // Add tags
            if ($request->has('tags')) {
                $meal->tags()->sync($request->input('tags'));
            }

            // Add allergens
            if ($request->has('allergens')) {
                $meal->allergens()->sync($request->input('allergens'));
            }

            // Add recipe ingredients
            $this->updateRecipeIngredients($meal, $request->input('ingredients', []));

            return redirect()->route('meals.index')->with('success', 'Thêm món ăn mới thành công.');
        }
    }

    public function show($id)
    {
        $meal = MealModel::with([
            'dietType',
            'mealType',
            'tags',
            'allergens',
            'recipeIngredients.ingredient'
        ])->findOrFail($id);

        return view('admin.meals.show', [
            'meal' => $meal
        ]);
    }

    public function destroy($id)
    {
        $meal = MealModel::findOrFail($id);

        // Delete image file if exists
        if ($meal->image_url) {
            $imagePath = public_path('uploads/meals/' . $meal->image_url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $meal->delete();
        return redirect()->route('meals.index')->with('success', 'Đã xóa món ăn.');
    }

    /**
     * Get meal types for AJAX requests
     */
    public function getMealTypes()
    {
        return response()->json(MealTypeModel::select('id', 'name')->get());
    }

    /**
     * Get diet types for AJAX requests  
     */
    public function getDietTypes()
    {
        return response()->json(DietTypeModel::select('id', 'name')->get());
    }

    /**
     * Update recipe ingredients for a meal
     */
    private function updateRecipeIngredients($meal, $ingredients)
    {
        // Delete existing recipe ingredients
        $meal->recipeIngredients()->delete();

        // Add new recipe ingredients
        if (!empty($ingredients)) {
            foreach ($ingredients as $ingredient) {
                if (
                    isset($ingredient['ingredient_id']) && isset($ingredient['quantity'])
                    && !empty($ingredient['ingredient_id']) && !empty($ingredient['quantity'])
                ) {

                    // Create recipe ingredient with default total_calo
                    $recipeIngredient = $meal->recipeIngredients()->create([
                        'ingredient_id' => $ingredient['ingredient_id'],
                        'quantity' => $ingredient['quantity'],
                        'total_calo' => 0 // Set default value first
                    ]);

                    // Calculate and update total calories
                    $totalCalo = $recipeIngredient->calculateTotalCalo();
                    $recipeIngredient->update(['total_calo' => $totalCalo]);
                }
            }
        }
    }
}
