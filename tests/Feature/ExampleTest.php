<?php

test('the root redirects to todos', function () {
    $response = $this->get('/');

    $response->assertRedirect('/todos');
});

test('todos index page can be rendered', function () {
    $response = $this->get('/todos');

    $response->assertStatus(200);
    $response->assertSee('KOTA KLASIK');
    $response->assertSee('Daily Planner');
});
