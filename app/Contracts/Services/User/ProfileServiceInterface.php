<?php

namespace App\Contracts\Services\User;

use Illuminate\Http\Request;


interface ProfileServiceInterface
{
    /**
     * Get ProfileId Data
     *
     * @return void
     */
    public function getProfileList();

    public function showProfilebyId($profileId);

    public function createProfile($validated);

    public function updateProfile($profileInfo,$profileId);

    public function deleteProfile($profileId);
}
