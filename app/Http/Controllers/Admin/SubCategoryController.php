<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a paginated list of sub categories.
     *
     * This method is responsible for retrieving a paginated list of sub categories
     * from the database and transforming the data into a custom format suitable
     * for display. The categories are sorted in descending order of creation
     * and transformed into an array format containing sub category ID, category ID, title, slug,
     * and description.
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return SubCategory::query()
            ->latest()
            ->paginate()
            ->through(fn ($subcategory) => [
                'id' => $subcategory->id,
                'category_id' => $subcategory->category_id,
                'title' => $subcategory->title,
                'slug' => $subcategory->slug,
                'description' => $subcategory->description,
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
     * Store a newly created sub category in the database.
     *
     * This method is responsible for creating a new category record in the database
     * based on the data provided in the request body. It expects an instance of the
     * Illuminate\Http\Request class containing the sub category data. Upon successful
     * creation, it returns a JSON response with a success message and the created
     * category details.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcategory = SubCategory::create($request->post());
        return response()->json([
            'message'=>'SubCategory Created Successfully!!',
            'subcategory'=>$subcategory
        ]);
    }

    /**
     * Display the specified sub category.
     *
     * This method is responsible for retrieving and displaying the details of
     * the specified category. It expects an instance of the SubCategory model as a
     * parameter, representing the category to be displayed. It returns a JSON
     * response containing the details of the specified category.
     * 
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subcategory)
    {
        return response()->json($subcategory);

    }

    /**
     * Show the form for editing the specified sub category.
     *
     * This method is responsible for retrieving the specified category
     * for editing. It expects an instance of the SubCategory model as a
     * parameter, representing the category to be edited. It returns the
     * category instance, which can be used to populate an edit form.
     * 
     * @param  \App\Models\SubCategory  $subcategory
     * @return \App\Models\SubCategory
     */
    public function edit(SubCategory $subcategory)
    {
        return $subcategory;
    }

    /**
     * Update the specified sub category in the database.
     *
     * This method is responsible for updating the details of the specified
     * sub category in the database based on the data provided in the request body.
     * It expects an instance of the Illuminate\Http\Request class containing
     * the updated sub category data and an instance of the SubCategory model representing
     * the sub category to be updated. Upon successful update, it returns the updated
     * sub category instance.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subcategory
     * @return \App\Models\SubCategory
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $subcategory->fill($request->post())->save();
        return $subcategory;
    }

    /**
     * Remove the specified sub category from the database.
     *
     * This method is responsible for deleting the specified sub category from
     * the database. It expects an instance of the SubCategory model representing
     * the sub category to be deleted. Upon successful deletion, it returns a JSON
     * response with a success message.
     * 
     * @param  \App\Models\SubCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return response()->json([
            'message'=>'SubCategory Deleted Successfully!!'
        ]);
    }
}
