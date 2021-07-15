<?php

namespace App\Services\User;

use App\Contracts\Dao\User\ProfileDaoInterface;
use App\Contracts\Services\User\ProfileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileService implements ProfileServiceInterface
{

    private $profileDao;

    /**
     * Create a new service instance.
     *
     * @param profileDaoInterface
     * @return void
     */
    public function __construct(ProfileDaoInterface $profileDao)
    {
        $this->profileDao = $profileDao;
    }

    //Api
    /**
     * Get userId Data
     *
     * @return array
     */
    public function getProfileList()
    {
        return $this->profileDao->getProfileList();
    }

    public function showProfilebyId($profileId){
        return $this->profileDao->showProfilebyId($profileId);
    }

    public function createProfile($validated)
    {
        $profile = $this->profileDao->createProfile($validated);
        Log::info($profile->id);
        Log::info($validated['profile']);
        Log::info($profile->image);

        Storage::putFileAs(
            config('path.profile') . $profile->id,
            $validated['profile'],
            $profile->image
        );

        $content = Storage::get(config('path.profile') . $profile->id . config('path.separator') . $profile->image);
        if(!empty($content)){
            Log::info('store S3');
            // Log::info($content);
            Storage::disk('s3')->put('user_profile/'.$profile->image, $content);
        }

        $get_file_path = config('path.user_profile').$profile->image;
        Log::info('get from S3');
        Log::info($get_file_path);
        return $profile;
    }

    public function updateProfile($profileInfo, $profileId)
    {
        $profile = $this->profileDao->updateProfile($profileInfo, $profileId);
        if ($profileInfo['profile']) {

            Storage::putFileAs(
                config('path.profile') . $profile->id,
                $profileInfo['profile'],
                $profile->image
            );

            $content = Storage::get(config('path.profile') . $profile->id . config('path.separator') . $profile->image);
            if (!empty($content)) {
                Log::info('store S3');
                // Log::info($content);
                Storage::disk('s3')->put('user_profile/' . $profile->image, $content);
            }
            
            Log::info('update delete s3');
            Log::info($profileInfo['oldProfile']);
            Storage::disk('s3')->delete('user_profile/' . $profileInfo['oldProfile']);
        }
        return $profile;
    }

    public function deleteProfile($profileId)
    {
        return $this->profileDao->deleteProfile($profileId);
    }
}
