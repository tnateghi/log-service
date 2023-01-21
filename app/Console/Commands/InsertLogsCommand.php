<?php

namespace App\Console\Commands;

use App\Models\ServiceLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InsertLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:insert {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read Logs from file and insert them to database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $handle = fopen($this->option('file'), "r");
        } catch (Exception $e) {
            Log::error($e);
            $this->error('could not open file');
            return;
        }

        $count = 0;

        if ($handle) {

            while (!feof($handle)) {
                $buffer = fgets($handle);

                $buffer = str_replace(['[', ']', '"'], '', $buffer);
                $data   = explode(' ', $buffer);

                ServiceLog::create([
                    "name"        => $data[0],
                    "method"      => $data[3],
                    "path"        => $data[4],
                    "date"        => Carbon::createFromFormat('d/M/Y:H:i:s', $data[2]),
                    "protocol"    => $data[5],
                    "status_code" => intval($data[6]),
                ]);

                // used for limit cpu usage
                usleep(0.001);

                $count++;
            }

            fclose($handle);
        }

        $this->info($count . ' logs inserted successfully');

        return Command::SUCCESS;
    }
}
