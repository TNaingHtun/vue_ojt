<?php

namespace App\Dao\User;

use App\Models\UserProfile;
use App\Contracts\Dao\User\ProfileDaoInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileDao implements ProfileDaoInterface
{
    /**
     * Get profile list Data
     *
     * @return array
     */
    public function getProfileList()
    {
        $result = DB::table('user_profiles as user_profile')
            ->select('user_profile.*')
            ->whereNull('user_profile.contract_end')
            ->get();
        if ($result) {
            return response()->json($result, 200);
        } else {
            return response()->json('No Data', 404);
        }
    }



    public function showProfilebyId($profileId)
    {
        $profile = UserProfile::find($profileId);
        return $profile;
    }

    public function createProfile($validated)
    {
        $profileName = time() . '.' . $validated['profile']->extension();
        Log::info($profileName);
        $profile = new UserProfile();
        $profile->name = $validated['name'];
        $profile->email = $validated['email'];
        $profile->phone = $validated['phone'];
        $profile->address = $validated['address'];
        $profile->image = $profileName;
        $profile->save();
        return $profile;
    }

    public function updateProfile($profileInfo, $id)
    {

        $profile = UserProfile::find($id);
        $profile->name = $profileInfo['name'];
        $profile->email = $profileInfo['email'];
        $profile->phone = $profileInfo['phone'];
        $profile->address = $profileInfo['address'];
        if ($profileInfo['profile']) {

            Log::info("is profile");
            $profileName = time() . '.' . $profileInfo['profile']->extension();
            Log::info($profileName);
            $profile->image = $profileName;
        }
        $profile->save();
        return $profile;
    }

    public function deleteProfile($profileId)
    {
        $profile = UserProfile::find($profileId);
        $image = UserProfile::select('image')
            ->where('id', $profileId)
            ->first();
        $image_name = $image['image'];
        Log::info($image_name);

        if ($profile) {
            $profile->delete();
            Storage::disk('s3')->delete('user_profile/' . $image_name);
            return 'Deleted Successfully!';
        }
        return 'Post Not Found!';
    }
}
