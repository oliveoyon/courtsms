<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageTemplate;
use App\Models\MessageTemplateCategory;
use Illuminate\Validation\Rule;

class MessageTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Message Template')->only(['index']);
        $this->middleware('permission:Create Message Template')->only(['store']);
        $this->middleware('permission:Edit Message Template')->only(['edit','update']);
        $this->middleware('permission:Delete Message Template')->only(['destroy']);
    }

    public function index()
    {
        $templates = MessageTemplate::with('category')->get();
        $categories = MessageTemplateCategory::all();
        return view('admin.message_templates.index', compact('templates','categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:message_templates,title',
            'category_id' => 'required|exists:message_template_categories,id',
            'channel' => ['required', Rule::in(['sms','whatsapp','both','email'])],
            'body_en_sms' => 'nullable|string',
            'body_en_whatsapp' => 'nullable|string',
            'body_bn_sms' => 'nullable|string',
            'body_bn_whatsapp' => 'nullable|string',
            'body_email' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // If new template is active, deactivate others in the same category
        if (!empty($validated['is_active'])) {
            MessageTemplate::where('category_id', $validated['category_id'])
                ->update(['is_active' => false]);
        }

        $template = MessageTemplate::create($validated);

        return response()->json([
            'success' => true,
            'template' => $template,
            'message' => __('template.success', ['action' => 'created']),
        ]);
    }

    public function edit($id)
    {
        $template = MessageTemplate::findOrFail($id);
        return response()->json($template);
    }

    public function update(Request $request, $id)
    {
        $template = MessageTemplate::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required','string','max:255', Rule::unique('message_templates')->ignore($template->id)],
            'category_id' => 'required|exists:message_template_categories,id',
            'channel' => ['required', Rule::in(['sms','whatsapp','both','email'])],
            'body_en_sms' => 'nullable|string',
            'body_en_whatsapp' => 'nullable|string',
            'body_bn_sms' => 'nullable|string',
            'body_bn_whatsapp' => 'nullable|string',
            'body_email' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // If updated template is active, deactivate others in the same category
        if (!empty($validated['is_active'])) {
            MessageTemplate::where('category_id', $validated['category_id'])
                ->where('id', '!=', $template->id)
                ->update(['is_active' => false]);
        }

        $template->update($validated);

        return response()->json([
            'success' => true,
            'template' => $template,
            'message' => __('template.success', ['action' => 'updated']),
        ]);
    }

    public function destroy($id)
    {
        $template = MessageTemplate::findOrFail($id);
        $template->delete();

        return response()->json([
            'success' => true,
            'message' => __('template.success', ['action' => 'deleted']),
        ]);
    }
}
