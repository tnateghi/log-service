<?php

namespace Tests\Feature;

use App\Models\ServiceLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ServiceLogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test logs count.
     *
     * @return void
     */
    public function test_logs_count()
    {
        $this->createLogFile(20);

        $this->artisan('logs:insert');

        $this->assertEquals(20, ServiceLog::count());

        $this->deleteLogFile();
    }

    /**
     * test logs count in api.
     *
     * @return void
     */
    public function test_logs_count_in_api()
    {
        $this->createLogFile(20);

        $this->artisan('logs:insert');

        $response = $this->get('/api/v1/logs/count');

        $response->assertStatus(200);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('count', 20)
            );

        $this->deleteLogFile();
    }

    private function createLogFile($logs_count)
    {
        for ($i = 0; $i < $logs_count; $i++) {
            Storage::disk('local')->append('test-logs-file.txt', 'order-service - [17/Sep/2022:10:21:53] "POST /orders HTTP/1.1" 201');
        }
    }

    private function deleteLogFile()
    {
        Storage::disk('local')->delete('test-logs-file.txt');
    }
}
