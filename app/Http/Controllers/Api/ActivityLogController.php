<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityLogResource;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function __invoke(Request $request)
    {
        $activity = Activity::latest()->where('causer_id', auth()->id())->paginate();

        return ActivityLogResource::collection($activity);
    }
}
