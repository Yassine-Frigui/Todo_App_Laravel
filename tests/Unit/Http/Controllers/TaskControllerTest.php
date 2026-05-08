<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_returns_view_with_tasks(): void
    {
        Task::create(['title' => 'Task 1']);
        Task::create(['title' => 'Task 2']);

        $response = $this->actingAs($this->user)->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        $response->assertSee('Task 1');
        $response->assertSee('Task 2');
    }

    public function test_create_returns_view(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.create'));

        $response->assertStatus(200);
    }

    public function test_store_creates_task_with_valid_data(): void
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task Description',
        ];

        $response = $this->actingAs($this->user)->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task',
            'description' => 'Task Description',
        ]);
    }

    public function test_store_fails_with_empty_title(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title' => '',
            'description' => 'Some description',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_fails_with_title_less_than_3_chars(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title' => 'ab',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_fails_with_title_exceeding_255_chars(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_edit_returns_view_with_task(): void
    {
        $task = Task::create(['title' => 'Edit Test Task']);

        $response = $this->actingAs($this->user)->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertViewHas('task');
        $response->assertSee('Edit Test Task');
    }

    public function test_update_modifies_task_correctly(): void
    {
        $task = Task::create([
            'title' => 'Original Title',
            'description' => 'Original Description',
            'completed' => false,
        ]);

        $response = $this->actingAs($this->user)->put(route('tasks.update', $task), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'completed' => 'on',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success');

        $task->refresh();
        $this->assertEquals('Updated Title', $task->title);
        $this->assertEquals('Updated Description', $task->description);
        $this->assertTrue($task->completed);
    }

    public function test_update_fails_validation(): void
    {
        $task = Task::create(['title' => 'Valid Title']);

        $response = $this->actingAs($this->user)->put(route('tasks.update', $task), [
            'title' => '',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_destroy_deletes_task(): void
    {
        $task = Task::create(['title' => 'Task to Delete']);
        $taskId = $task->id;

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('tasks', ['id' => $taskId]);
    }

    public function test_unauthenticated_user_cannot_access_tasks(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertRedirect(route('login'));
    }
}
