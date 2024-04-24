<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a paginated list of categories.
     *
     * This method is responsible for retrieving a paginated list of categories
     * from the database and transforming the data into a custom format suitable
     * for display. The categories are sorted in descending order of creation
     * and transformed into an array format containing category ID, title, slug,
     * and description.
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Category::query()
            ->latest()
            ->paginate()
            ->through(fn ($category) => [
                'id' => $category->id,
                'title' => $category->title,
                'slug' => $category->slug,
                'description' => $category->description,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created category in the database.
     *
     * This method is responsible for creating a new category record in the database
     * based on the data provided in the request body. It expects an instance of the
     * Illuminate\Http\Request class containing the category data. Upon successful
     * creation, it returns a JSON response with a success message and the created
     * category details.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create($request->post());
        return response()->json([
            'message'=>'Category Created Successfully!!',
            'category'=>$category
        ]);
    }

    /**
     * Display the specified category.
     *
     * This method is responsible for retrieving and displaying the details of
     * the specified category. It expects an instance of the Category model as a
     * parameter, representing the category to be displayed. It returns a JSON
     * response containing the details of the specified category.
     * 
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);

    }

    /**
     * Show the form for editing the specified category.
     *
     * This method is responsible for retrieving the specified category
     * for editing. It expects an instance of the Category model as a
     * parameter, representing the category to be edited. It returns the
     * category instance, which can be used to populate an edit form.
     * 
     * @param  \App\Models\Category  $category
     * @return \App\Models\Category
     */
    public function edit(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified category in the database.
     *
     * This method is responsible for updating the details of the specified
     * category in the database based on the data provided in the request body.
     * It expects an instance of the Illuminate\Http\Request class containing
     * the updated category data and an instance of the Category model representing
     * the category to be updated. Upon successful update, it returns the updated
     * category instance.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \App\Models\Category
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->post())->save();
        return $category;
    }

    /**
     * Remove the specified category from the database.
     *
     * This method is responsible for deleting the specified category from
     * the database. It expects an instance of the Category model representing
     * the category to be deleted. Upon successful deletion, it returns a JSON
     * response with a success message.
     * 
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message'=>'Category Deleted Successfully!!'
        ]);
    }
}
