<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function update(UpdateProfileRequest $request)
    {
        $profile = Auth::user();
        $profile->name = $request->name;
        $profile->email = $request->email;

        if ($profile->save()) {
            return response()->json(['profile' => $profile, 'status' => 200, 'success' => true]);
        }
        return response()->json(['status' => 403, 'success' => false]);
    }
}
