<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Document::with(['category', 'uploader']);

        // Apply access control
        if (!auth()->check()) {
            $query->public();
        } elseif (auth()->user()->hasRole('Super Admin')) {
            // Super Admin sees all
        } elseif (auth()->user()->hasRole('Admin') || auth()->user()->hasPermissionTo('view admin documents')) {
            $query->forAdmins();
        } elseif (auth()->user()->hasRole('Elder') || auth()->user()->hasPermissionTo('view elder documents')) {
            $query->forElders();
        } else {
            $query->forMembers();
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                  ->orWhere('title_sw', 'like', "%{$search}%")
                  ->orWhere('description_en', 'like', "%{$search}%")
                  ->orWhere('description_sw', 'like', "%{$search}%");
            });
        }

        $documents = $query->latest()->paginate(12);
        $categories = DocumentCategory::withCount('documents')->get();

        return view('documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Document::class);
        
        $categories = DocumentCategory::all();
        
        return view('documents.create', compact('categories'));
    }

    public function store(Request $request, NotificationService $notificationService)
    {
        $this->authorize('create', Document::class);

        $validated = $request->validate([
            'category_id' => 'required|exists:document_categories,id',
            'title_sw' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_sw' => 'nullable|string',
            'description_en' => 'nullable|string',
            'access_level' => 'required|in:public,members,elders,admin',
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,rar',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('documents', 'public');
            
            $validated['file_path'] = $path;
            $validated['file_type'] = $file->getMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $validated['uploaded_by'] = auth()->id();

        $document = Document::create($validated);

        // Notify relevant users about the new document
        $users = User::all();
        $notificationService->notifyDocumentUpload($document, $users);

        return redirect()->route('documents.index')
            ->with('success', __('documents.document_uploaded'));
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);
        
        $document->load(['category', 'uploader']);
        
        // Get related documents from same category
        $relatedDocuments = Document::where('category_id', $document->category_id)
            ->where('id', '!=', $document->id)
            ->limit(4)
            ->get();

        return view('documents.show', compact('document', 'relatedDocuments'));
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        // Delete the file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', __('documents.document_deleted'));
    }

    public function download(Document $document)
    {
        $this->authorize('download', $document);

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download(
            $document->file_path,
            $document->title . '.' . $document->getFileExtension()
        );
    }
}
