<?php

use App\Models\Todo;

test('can create a new todo agenda', function () {
    $response = $this->post('/todos', [
        'title' => 'Restorasi Jembatan Kuno',
        'description' => 'Pengecatan ulang tiang lampu gas kuno di sepanjang jembatan kota.',
        'is_completed' => false,
    ]);

    $response->assertRedirect('/todos');
    $this->assertDatabaseHas('todos', [
        'title' => 'Restorasi Jembatan Kuno',
    ]);
});

test('can update an existing todo agenda', function () {
    $todo = Todo::create([
        'title' => 'Perbaikan Jalur Trem Kota',
        'description' => 'Pembersihan rel di bundaran balai kota.',
        'is_completed' => false,
    ]);

    $response = $this->put("/todos/{$todo->id}", [
        'title' => 'Perbaikan Jalur Trem Kota - Selesai',
        'description' => 'Rel telah bersih dan diuji coba.',
        'is_completed' => true,
    ]);

    $response->assertRedirect('/todos');
    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'title' => 'Perbaikan Jalur Trem Kota - Selesai',
        'is_completed' => true,
    ]);
});

test('can toggle todo completion status', function () {
    $todo = Todo::create([
        'title' => 'Eksplorasi Kedai Kopi Vintage',
        'description' => 'Mencoba manual brew.',
        'is_completed' => false,
    ]);

    $response = $this->patch("/todos/{$todo->id}/toggle");

    $response->assertRedirect();
    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'is_completed' => true,
    ]);

    $response2 = $this->patch("/todos/{$todo->id}/toggle");
    $response2->assertRedirect();
    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'is_completed' => false,
    ]);
});

test('can delete a todo agenda', function () {
    $todo = Todo::create([
        'title' => 'Jadwal Rapat Sementara',
        'description' => 'Catatan tentatif.',
        'is_completed' => false,
    ]);

    $response = $this->delete("/todos/{$todo->id}");

    $response->assertRedirect('/todos');
    $this->assertDatabaseMissing('todos', [
        'id' => $todo->id,
    ]);
});
