<?php

namespace App\Contracts\Services\User;

use Illuminate\Http\Request;


interface UserServiceInterface
{
    /**
     * Get userId Data
     *
     * @return void
     */
    public function getUserId();
}
