<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        // try {
        //     $categories = Category::latest()->paginate(10);
        return view('Admin.category.index');
        // } catch (\Throwable $e) {
        //     return back()->with('error', 'Failed to load categories');
        // }
    }
    // list get data
    public function categoryData(Request $request)
    {
        $q = Category::query();

        if ($request->search)
            $q->where('name', 'like', "%{$request->search}%");

        if ($request->sortCol)
            $q->orderBy($request->sortCol, $request->sortDir ?? 'asc');

        $paginated = $q->paginate($request->perPage ?? 10);

        return response()->json([
            'total' => $paginated->total(),
            'data'  => $paginated->items(),
        ]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name'
            ], [
                'name.required' => 'Category name is required.',
                'name.unique' => 'Category name already exists.',
            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return redirect()->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            Category::create([
                'name' => $request->name
            ]);

            Session::flash('success', 'Category created successfully');
            return redirect()->route('admin.category.index')
                ->with('success', 'Category created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create category');
        }
    }

    public function edit(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            Session::flash('success', 'Category created successfully');
            return view('admin.category.create', compact('category'));
        } catch (\Throwable $e) {
            Session::flash('success', 'Category Not Found!');
            return redirect()->route('category.index');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $id
            ], [
                'name.required' => 'Category name is required.',
                'name.unique' => 'Category name already exists.',
            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return redirect()->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $category->update([
                'name' => $request->name
            ]);
            Session::flash('success', 'Category updated successfully');
            return redirect()->route('admin.category.index');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Failed to update category');
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            Session::flash('success', 'Category deleted successfully');
            return redirect()->route('admin.category.index');
        } catch (\Throwable $e) {
            return redirect()->route('category.index')
                ->with('error', 'Failed to delete category');
        }
    }
}
