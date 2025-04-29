<?php

declare(strict_types=1);


namespace App\Console;

use Illuminate\Console\Scheduling\Schedule as BaseSchedule;

final class Scheduler
{
    /**
     * Запуск работ по расписанию.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function run(BaseSchedule $schedule) : void
    {
        // Системные задачи

        // Задачи связанные с приложением

        // Задачи связанные с клиентами
    }
}
