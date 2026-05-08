<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_view_task_list(): void
    {
        Task::create(['user_id' => $this->user->id, 'title' => 'Test Task 1']);
        Task::create(['user_id' => $this->user->id, 'title' => 'Test Task 2']);

        $response = $this->actingAs($this->user)->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertSee('Mes Taches');
    }

    public function test_user_can_create_task(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title' => 'New Feature Task',
            'description' => 'Feature test description',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'New Feature Task',
            'description' => 'Feature test description',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_can_view_edit_task_page(): void
    {
        $task = Task::create(['user_id' => $this->user->id, 'title' => 'Edit Me']);

        $response = $this->actingAs($this->user)->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertSee('Edit Me');
    }

    public function test_user_can_update_task(): void
    {
        $task = Task::create([
            'user_id' => $this->user->id,
            'title' => 'Old Title',
            'description' => 'Old Description',
        ]);

        $response = $this->actingAs($this->user)->put(route('tasks.update', $task), [
            'title' => 'New Title',
            'description' => 'New Description',
            'completed' => 'on',
        ]);

        $response->assertRedirect(route('tasks.index'));

        $task->refresh();
        $this->assertEquals('New Title', $task->title);
        $this->assertEquals('New Description', $task->description);
        $this->assertTrue($task->completed);
    }

    public function test_user_can_delete_task(): void
    {
        $task = Task::create(['user_id' => $this->user->id, 'title' => 'Delete Me']);
        $taskId = $task->id;

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $taskId]);
    }

    public function test_full_task_crud_workflow(): void
    {
        // Create
        $createResponse = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title' => 'CRUD Workflow Task',
            'description' => 'Testing full workflow',
        ]);
        $createResponse->assertRedirect(route('tasks.index'));

        // Read
        $task = Task::where('title', 'CRUD Workflow Task')->first();
        $this->assertNotNull($task);

        // Update
        $updateResponse = $this->actingAs($this->user)->put(route('tasks.update', $task), [
            'title' => 'Updated Workflow Task',
            'description' => 'Updated description',
        ]);
        $updateResponse->assertRedirect(route('tasks.index'));

        $task->refresh();
        $this->assertEquals('Updated Workflow Task', $task->title);

        // Delete
        $deleteResponse = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $deleteResponse->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
