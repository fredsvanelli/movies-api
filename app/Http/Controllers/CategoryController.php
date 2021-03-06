<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->search){
            $query->where('name', 'like', "%{$request->search}%");
        }

        $query->orderBy(
            $request->input('order_by', 'name'),
            $request->input('order', 'asc')
        );

        if ($request->has('with_movies')){
            $query->with(['movies.categories']);
        }

        if ($request->has('all')) {
            $categories = $query->get();
        } else {
            $categories = $query->paginate($request->input('per_page', 36));
        }

        return CategoryResource::collection($categories);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $category = Category::create(array_merge(
            $data,
            ['slug' => Str::slug($request->name)]
        ));

        return (new CategoryResource($category))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $category->fill(array_merge(
            $data,
            ['slug' => Str::slug($request->name)]
        ))->save();

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
