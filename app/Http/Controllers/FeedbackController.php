<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::all();
        return Inertia::render('Feedback/Index', [
            'feedback' => $feedback
        ]);
    }

    public function create()
    {
        return Inertia::render('Feedback/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'developer_id' => 'nullable|exists:developers,id',
            'sale_id' => 'nullable|exists:sales_documents,id',
            'message' => 'required|string|max:1000',
        ]);

        if (!isset($validated['developer_id']) && !isset($validated['sale_id'])) {
            return back()->withErrors(['message' => 'Feedback must be associated with a developer or a sale.']);
        }

        Feedback::create($validated);
        return redirect()->route('feedback.index')->with('success', 'Feedback submitted.');
    }

    public function show(Feedback $feedback)
    {
        return Inertia::render('Feedback/Show', [
            'feedback' => $feedback
        ]);
    }

    public function edit(Feedback $feedback)
    {
        return Inertia::render('Feedback/Edit', [
            'feedback' => $feedback
        ]);
    }

    public function update(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);
        $feedback->update($validated);
        return redirect()->route('feedback.index')->with('success', 'Feedback updated.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback deleted.');
    }
}
