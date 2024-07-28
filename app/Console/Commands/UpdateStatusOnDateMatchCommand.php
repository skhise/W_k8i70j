<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateStatusOnDateMatchCommand extends Command
{
    protected $signature = 'update:status';

    protected $description = 'Update status based on date match';

    public function handle()
    {
        // Call the stored procedure or perform the desired logic
        // DB::statement('CALL UpdateStatusOnDateMatch()');
        $sql = "UPDATE contracts SET CNRT_Status = 3 WHERE DATE(CNRT_EndDate) < CURDATE()";
        DB::statement($sql);

        // $sql1 = "UPDATE contracts SET CNRT_Status = 2 WHERE DATEDIFF(CNRT_EndDate, CURDATE()) = 15";
        // DB::statement($sql1);

        $this->info('Status updated successfully');
    }
}

?>