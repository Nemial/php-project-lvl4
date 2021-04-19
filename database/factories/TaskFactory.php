<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
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
        $status = TaskStatus::first();
        $user = User::first();
        return [
            'name' => $this->faker->unique()->name,
            'status_id' => $status->id,
            'description' => $this->faker->text,
            'created_by_id' => $user->id,
            'assigned_to_id' => $user->id
        ];
    }
}
