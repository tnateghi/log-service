<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ServiceLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function scopeFilter($query, Request $request)
    {
        if ($request->filled('serviceNames')) {
            $query->whereIn('name', $request->serviceNames);
        }

        if ($request->filled('statusCode')) {
            $query->where('status_code', $request->statusCode);
        }

        if ($request->filled('startDate')) {
            $query->whereDate('date', '>=', $request->startDate);
        }

        if ($request->filled('endDate')) {
            $query->whereDate('date', '<=', $request->endDate);
        }

        return $query;
    }
}
