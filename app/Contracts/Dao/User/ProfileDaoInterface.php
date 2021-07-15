<?php

namespace App\Contracts\Dao\User;

use Illuminate\Http\Request;


interface ProfileDaoInterface
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
