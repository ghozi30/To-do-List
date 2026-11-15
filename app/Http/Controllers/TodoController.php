<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTodoRequest;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoController extends Controller
{
    /**
     * Menampilkan daftar Todo dengan filter status, pencarian, dan statistik ringkas.
     */
    public function index(Request $request): View
    {
        $status = (string) $request->query('status', 'all');
        $search = trim((string) $request->query('q', ''));

        $stats = Todo::query()
            ->toBase()
            ->selectRaw('COUNT(*) as total, COALESCE(SUM(CASE WHEN is_completed = true THEN 1 ELSE 0 END), 0) as completed')
            ->first();

        $totalCount = (int) ($stats->total ?? 0);
        $completedCount = (int) ($stats->completed ?? 0);
        $activeCount = $totalCount - $completedCount;

        $todos = Todo::query()
            ->select(['id', 'title', 'description', 'is_completed', 'created_at', 'updated_at'])
            ->when($status === 'active', fn ($query) => $query->where('is_completed', false))
            ->when($status === 'completed', fn ($query) => $query->where('is_completed', true))
            ->when($search !== '', function ($query) use ($search): void {
                $pattern = '%'.mb_strtolower($search).'%';
                $query->where(function ($subQuery) use ($pattern): void {
                    $subQuery->whereRaw('LOWER(title) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(COALESCE(description, \'\')) LIKE ?', [$pattern]);
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('todo.index', compact(
            'todos',
            'status',
            'search',
            'totalCount',
            'activeCount',
            'completedCount',
        ));
    }

    /**
     * Menampilkan form tambah Todo.
     */
    public function create(): View
    {
        return view('todo.create');
    }

    /**
     * Menyimpan Todo baru.
     */
    public function store(SaveTodoRequest $request): RedirectResponse
    {
        Todo::create($request->todoAttributes());

        return redirect()->route('todos.index')
            ->with('success', 'Agenda baru berhasil dicatat ke jurnalmu ✨');
    }

    /**
     * Menampilkan detail Todo.
     */
    public function show(Todo $todo): View
    {
        return view('todo.show', compact('todo'));
    }

    /**
     * Menampilkan form edit Todo.
     */
    public function edit(Todo $todo): View
    {
        return view('todo.edit', compact('todo'));
    }

    /**
     * Memperbarui Todo.
     */
    public function update(SaveTodoRequest $request, Todo $todo): RedirectResponse
    {
        $todo->update($request->todoAttributes());

        return redirect()->route('todos.index')
            ->with('success', 'Catatan agenda berhasil diperbarui ☕');
    }

    /**
     * Mengubah status selesai Todo secara instan.
     */
    public function toggle(Todo $todo): RedirectResponse
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
     * Menghapus Todo.
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Agenda berhasil dihapus dari jurnal.');
    }
}
