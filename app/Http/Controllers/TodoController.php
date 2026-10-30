<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Menampilkan semua Todo
     */
    public function index()
    {
        $todos = Todo::latest('id')->get();

        return view('todo.index', compact('todos'));
    }

    /**
     * Menampilkan form tambah Todo
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Menyimpan Todo baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_completed' => ['sometimes', 'boolean'],
        ], [
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 5000 karakter.',
            'is_completed.boolean' => 'Status selesai tidak valid.',
        ]);

        $validated['is_completed'] = $request->boolean('is_completed');

        Todo::create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Agenda baru berhasil dicatat ke jurnalmu ✨');
    }

    /**
     * Menampilkan detail Todo
     */
    public function show(Todo $todo)
    {
        return view('todo.show', compact('todo'));
    }

    /**
     * Menampilkan form edit Todo
     */
    public function edit(Todo $todo)
    {
        return view('todo.edit', compact('todo'));
    }

    /**
     * Memperbarui Todo
     */
    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_completed' => ['sometimes', 'boolean'],
        ], [
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 5000 karakter.',
            'is_completed.boolean' => 'Status selesai tidak valid.',
        ]);

        $validated['is_completed'] = $request->boolean('is_completed');

        $todo->update($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Catatan agenda berhasil diperbarui ☕');
    }

    /**
     * Mengubah status selesai Todo secara instan
     */
    public function toggle(Todo $todo)
    {
        $todo->update([
            'is_completed' => ! $todo->is_completed,
        ]);

        $message = $todo->is_completed
            ? 'Agenda ditandai selesai! 🌿'
            : 'Agenda diaktifkan kembali ☕';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Menghapus Todo
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Agenda berhasil dihapus dari jurnal.');
    }
}
