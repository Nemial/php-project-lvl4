<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaskStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Новый',
        ];
    }

    /**
     * @return TaskStatusFactory
     */
    public function statusTest(): TaskStatusFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => ' На тестировании',
            ];
        });
    }

    /**
     * @return TaskStatusFactory
     */
    public function statusWork(): TaskStatusFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'В работе'
            ];
        });
    }

    /**
     * @return TaskStatusFactory
     */
    public function statusData(): TaskStatusFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Тестовый',
            ];
        });
    }

    /**
     * @return TaskStatusFactory
     */
    public function statusUpdatedData(): TaskStatusFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Изменённый',
            ];
        });
    }
}
