<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageTemplateCategory;

class MessageTemplateCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Message Template Category')->only(['index']);
        $this->middleware('permission:Create Message Template Category')->only(['store']);
        $this->middleware('permission:Edit Message Template Category')->only(['edit','update']);
        $this->middleware('permission:Delete Message Template Category')->only(['destroy']);
    }

    public function index()
    {
        $categories = MessageTemplateCategory::all();
        return view('admin.message_template_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255|unique:message_template_categories,name_en',
            'name_bn' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $category = MessageTemplateCategory::create($validated);

        return response()->json([
            'success' => true,
            'category' => $category,
            'message' => __('template.success.create')
        ]);
    }

    public function edit($id)
    {
        $category = MessageTemplateCategory::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = MessageTemplateCategory::findOrFail($id);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255|unique:message_template_categories,name_en,'.$category->id,
            'name_bn' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'category' => $category,
            'message' => __('template.success.update')
        ]);
    }

    public function destroy($id)
    {
        $category = MessageTemplateCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => __('template.success.delete')
        ]);
    }
}
