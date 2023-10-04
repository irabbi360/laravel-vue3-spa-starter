<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Exception;
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
        $profile->name = $request->input('name');
        $profile->email = $request->input('email');

        if ($profile->save()) {
            try {
                if ($request->hasFile('avatar')) {
                    $profile->addMediaFromRequest('avatar')->preservingOriginal()->toMediaCollection('avatars');
                    error_log('success');
                }
            } catch (Exception $e) {
                error_log($e->getMessage());

            }
            return $this->successResponse($profile, 'User updated');
        }
        return response()->json(['status' => 403, 'success' => false]);
    }

    public function user(Request $request)
    {
        $user = $request->user();
    ;
        try {
            if (env('RESIZE_AVATAR') === true) {
                $avatar = $user->getMedia('*')[0]->getUrl('resized-avatar');;
            } else {
                $avatar = $user->getMedia('*')[0]->getUrl();
            }
            $user->setAttribute('avatar', $avatar);
        } catch (Exception $e) {
//           error_log($e->getMessage());
//            $avatar = "";
        }

        return $this->successResponse($user, 'User found');
    }
}
