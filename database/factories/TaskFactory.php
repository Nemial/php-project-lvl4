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
        $statuses = TaskStatus::get();
        [$status] = $statuses;
        $defaultUserId = 1;
        return [
            'name' => $this->faker->name,
            'status_id' => $status->id,
            'description' => $this->faker->text,
            'created_by_id' => $defaultUserId,
            'assigned_to_id' => $defaultUserId
        ];
    }
}
