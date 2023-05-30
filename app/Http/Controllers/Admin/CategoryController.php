<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(9);

        return view('admin.category.index', [
            'categories' => $categories
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.edite', [
            
            'category' => new Category() 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = ['designation' => $request->validated('designation')];
        $category = Category::create($data);

        if($request->hasFile('image_path'))
        {
            //get filename with extension
            $filenameWithExtension = $request->file('image_path')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            //get the extension
            $extension = $request->file('image_path')->getClientOriginalExtension();

            //filename to store
            $filenameStore = $filename. '_'.time().'.'.$extension;

            //upload file
            $request->file('image_path')->storeAs('public/categoriy_images/'.$category->id, $filenameStore);

            $category->image_path = 'categoriy_images/'.$category->id.'/'. $filenameStore;

            $category->save();

        }

        return to_route('admin.category.index');

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edite', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if($request->hasFile('image_path'))
        {

            if($category->image_path !== null)
            {
                Storage::delete($category->getImagePath());
            }

            //get filename with extension
            $filenameWithExtension = $request->file('image_path')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            //get the extension
            $extension = $request->file('image_path')->getClientOriginalExtension();

            //filename to store
            $filenameStore = $filename. '_'.time().'.'.$extension;

            //upload file
            $request->file('image_path')->storeAs('public/categoriy_images/'.$category->id, $filenameStore);

            $category->image_path = 'categoriy_images/'.$category->id.'/'. $filenameStore;

            $category->save();

        }

        $data = ['designation' => $request->validated('designation')];

        $category->update($data);

        return to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
