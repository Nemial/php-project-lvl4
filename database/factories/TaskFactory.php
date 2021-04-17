<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = TaskStatus::factory()->create();
        $defaultUserId = 1;
        return [
            'name' => $this->faker->name,
            'status_id' => $status->id,
            'description' => $this->faker->text,
            'created_by_id' => $defaultUserId,
            'assigned_to_id' => $defaultUserId
        ];
    }

    public function taskNew($user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'created_by_id' => $user->id,
                'assigned_to_id' => $user->id
            ];
        });
    }
    public function taskData($user, $status)
    {
        return $this->state(function (array $attributes) use ($user, $status) {
            return [
                'name' => 'StoreTest',
                'status_id' => $status->id,
                'description' => 'It is stored test task',
                'created_by_id' => $user->id,
                'assigned_to_id' => $user->id
            ];
        });
    }
    public function taskUpdatedData($user, $status)
    {
        return $this->state(function (array $attributes) use ($user, $status) {
            return [
                'name' => 'TestUpdated',
                'status_id' => $status->id,
                'created_by_id' => $user->id,
                'assigned_to_id' => $user->id
            ];
        });
    }
}
