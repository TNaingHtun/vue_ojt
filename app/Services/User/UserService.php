<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserService implements UserServiceInterface
{

    private $userDao;

    /**
     * Create a new service instance.
     *
     * @param UserDaoInterface
     * @return void
     */
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    //Api
    /**
     * Get userId Data
     *
     * @return array
     */
    public function getUserId(){
        return $this->userDao->getUserId();
    }
}
