<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Menampilkan semua feedback
    public function index()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return view('feedback', compact('feedbacks'));
    }
    public function fetchFeedback(Request $request)
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return response()->json($feedbacks);
    }

    // Menyimpan feedback baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email',
            'komentar' => 'required'
        ]);

        $feedback = Feedback::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $feedback
        ]);
    }

    // Menampilkan detail feedback
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('feedback.show', compact('feedback'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('feedback.edit', compact('feedback'));
    }

    // Update feedback
    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email',
            'komentar' => 'required'
        ]);

        $feedback->update($validated);

        if($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $feedback
            ]);
        }

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil diperbarui!');
    }

    // Hapus feedback
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        if(request()->ajax()) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil dihapus!');
    }

    // API untuk mendapatkan feedback terbaru (AJAX)
    public function getLatest()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->take(5)->get();
        return response()->json($feedbacks);
    }
}
