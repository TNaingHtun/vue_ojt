<?php

namespace App\Contracts\Dao\User;

use Illuminate\Http\Request;


interface UserDaoInterface
{
    /**
     * Get userId Data
     *
     * @return void
     */
    public function getUserId();
}
