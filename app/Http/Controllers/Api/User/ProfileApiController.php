<?php

namespace App\Http\Controllers\Api\User;

use App\Models\UserProfile;
use App\Http\Controllers\Controller;
use App\Contracts\Services\User\ProfileServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Posts\ProfileCreateAPIRequest;
use App\Http\Requests\Posts\ProfileEditAPIRequest;
use Illuminate\Support\Facades\Log;

class ProfileApiController extends Controller
{
    private $profileInterface;

    /**
     * Create a new controller instance.
     *
     * @param profileInterface
     * @return void
     */
    public function __construct(ProfileServiceInterface $profileInterface)
    {
        $this->profileInterface = $profileInterface;
    }

    /**
     * Get User List
     *
     * @return array
     */
    public function showProfileList()
    {
        $header_user_id = app('request')->header('User-Id');
        Log::info('header userId');
        Log::info($header_user_id);
        $header_token_data = app('request')->header('Authorization');
        Log::info('header token');
        Log::info($header_token_data);
        $result = $this->profileInterface->getProfileList();
        return $result;
    }

    public function showProfilebyId($profileId)
    {
        Log::info($profileId);
        $header_user_id = app('request')->header('User-Id');
        Log::info('header userId');
        Log::info($header_user_id);
        $header_token_data = app('request')->header('Authorization');
        Log::info('header token');
        Log::info($header_token_data);
        $profile = $this->profileInterface->showProfilebyId($profileId);
        Log::info($profile);
        return response()->json($profile);
    }

    public function createProfile(ProfileCreateAPIRequest $request)
    {
        Log::info($request);
        $profile = $this->profileInterface->createProfile($request);
        return response()->json($profile);
    }

    public function updateProfile(ProfileEditAPIRequest $request, $profileId)
    {
        Log::info('enter');
        Log::info($request);
        Log::info($profileId);
        $header_user_id = app('request')->header('User-Id');
        Log::info('header userId');
        Log::info($header_user_id);
        $header_token_data = app('request')->header('Authorization');
        Log::info('header token');
        Log::info($header_token_data);

        $profile = $this->profileInterface->updateProfile($request, $profileId);
        return response()->json($profile);
    }

    public function deleteProfile($profileId)
    {
        Log::info($profileId);
        $msg = $this->profileInterface->deleteProfile($profileId);
        return $msg;
    }
}
