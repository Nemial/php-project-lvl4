<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = collect(['Новый', 'В работе', 'На тестировании', 'Завершён']);
        $statuses->map(
            function ($statusName) {
                $taskStatus = new TaskStatus();
                $taskStatus->name = $statusName;
                $taskStatus->save();
            }
        );
    }
}
