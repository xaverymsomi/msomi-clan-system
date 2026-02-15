<?php

namespace App\Http\Controllers;

use App\Models\Tradition;
use App\Models\TraditionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TraditionController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Tradition::with('category')->published();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_sw', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('description_sw', 'like', "%{$search}%")
                  ->orWhere('description_en', 'like', "%{$search}%");
            });
        }

        $traditions = $query->latest()->paginate(12);
        $categories = TraditionCategory::all();

        return view('traditions.index', compact('traditions', 'categories'));
    }

    public function show(Tradition $tradition)
    {
        // Increment view count
        $tradition->incrementViews();

        // Load relationships
        $tradition->load(['category', 'media', 'creator']);

        // Get related traditions
        $relatedTraditions = Tradition::published()
            ->where('category_id', $tradition->category_id)
            ->where('id', '!=', $tradition->id)
            ->take(3)
            ->get();

        return view('traditions.show', compact('tradition', 'relatedTraditions'));
    }

    public function create()
    {
        $this->authorize('create', Tradition::class);
        $categories = TraditionCategory::all();
        return view('traditions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Tradition::class);

        $validated = $request->validate([
            'category_id' => 'required|exists:tradition_categories,id',
            'title_sw' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_sw' => 'nullable|string',
            'description_en' => 'nullable|string',
            'content_sw' => 'nullable|string',
            'content_en' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('traditions', 'public');
        }

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $tradition = Tradition::create($validated);

        return redirect()->route('traditions.show', $tradition)
            ->with('success', __('traditions.tradition_saved'));
    }

    public function edit(Tradition $tradition)
    {
        $this->authorize('update', $tradition);
        $categories = TraditionCategory::all();
        return view('traditions.edit', compact('tradition', 'categories'));
    }

    public function update(Request $request, Tradition $tradition)
    {
        $this->authorize('update', $tradition);

        $validated = $request->validate([
            'category_id' => 'required|exists:tradition_categories,id',
            'title_sw' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_sw' => 'nullable|string',
            'description_en' => 'nullable|string',
            'content_sw' => 'nullable|string',
            'content_en' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($tradition->featured_image) {
                Storage::disk('public')->delete($tradition->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('traditions', 'public');
        }

        $validated['updated_by'] = auth()->id();
        $tradition->update($validated);

        return redirect()->route('traditions.show', $tradition)
            ->with('success', __('traditions.tradition_saved'));
    }

    public function destroy(Tradition $tradition)
    {
        $this->authorize('delete', $tradition);

        if ($tradition->featured_image) {
            Storage::disk('public')->delete($tradition->featured_image);
        }

        $tradition->delete();

        return redirect()->route('traditions.index')
            ->with('success', __('traditions.tradition_deleted'));
    }
}
