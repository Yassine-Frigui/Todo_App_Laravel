<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created_with_mass_assignment(): void
    {
        $task = Task::create([
            'title' => 'Test Task',
            'description' => 'Test Description',
            'completed' => false,
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'completed' => 0,
        ]);
    }

    public function test_task_can_be_updated(): void
    {
        $task = Task::create([
            'title' => 'Original Title',
            'description' => 'Original Description',
            'completed' => false,
        ]);

        $task->update([
            'title' => 'Updated Title',
            'completed' => true,
        ]);

        $this->assertEquals('Updated Title', $task->fresh()->title);
        $this->assertTrue($task->fresh()->completed);
    }

    public function test_task_can_be_deleted(): void
    {
        $task = Task::create([
            'title' => 'Task to Delete',
            'description' => 'Will be deleted',
        ]);

        $taskId = $task->id;
        $task->delete();

        $this->assertDatabaseMissing('tasks', ['id' => $taskId]);
    }

    public function test_task_has_correct_fillable_attributes(): void
    {
        $task = new Task;
        $fillable = $task->getFillable();

        $this->assertContains('title', $fillable);
        $this->assertContains('description', $fillable);
        $this->assertContains('completed', $fillable);
    }

    public function test_task_has_timestamps(): void
    {
        $task = Task::create([
            'title' => 'Timestamp Test',
            'description' => 'Testing timestamps',
        ]);

        $this->assertNotNull($task->created_at);
        $this->assertNotNull($task->updated_at);
    }

    public function test_task_default_completed_is_false(): void
    {
        $task = Task::create([
            'title' => 'Default Completed Test',
            'completed' => false,
        ]);

        $this->assertFalse($task->completed);
    }
}
