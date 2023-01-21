<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ServiceLog;
use Illuminate\Http\Request;

class ServiceLogController extends Controller
{
    public function count(Request $request)
    {
        $request->validate([
            'serviceNames' => 'nullable|array',
            'statusCode'   => 'nullable|string',
            'startDate'    => 'nullable|date',
            'endDate'      => 'nullable|date',
        ]);

        $logs_count = ServiceLog::filter($request)->count();

        return response()->json([
            'count' => $logs_count
        ]);
    }
}
