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
    public function definition()
    {
        return [
            'name' => 'Новый',
        ];
    }

    public function statusTest()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => ' На тестировании',
            ];
        });
    }
    public function statusWork()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'В работе'
            ];
        });
    }
    public function statusData()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Тестовый',
            ];
        });
    }
    public function statusUpdatedData()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Изменённый',
            ];
        });
    }
}
