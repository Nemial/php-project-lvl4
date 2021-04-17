<?php

namespace Database\Factories;

use App\Models\Label;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Label::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Первая метка',
            'description' => 'Первое описание'
        ];
    }

    /**
     * @return LabelFactory
     */
    public function labelData(): LabelFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Тестовая метка',
                'description' => 'Тестовое описание'
            ];
        });
    }

    /**
     * @return LabelFactory
     */
    public function labelUpdatedData(): LabelFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Изменили метку',
            ];
        });
    }
}
