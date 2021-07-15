<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    private $userInterface;

    /**
     * Create a new controller instance.
     *
     * @param UserServiceInterface
     * @return void
     */
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userInterface = $userServiceInterface;
    }

    /**
     * Get User List
     *
     * @return array
     */
    public function showUserList(){
        
        $result = $this->userInterface->getUserId();
        return $result;
    }
}
