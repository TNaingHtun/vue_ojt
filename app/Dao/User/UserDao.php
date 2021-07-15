<?php

namespace App\Dao\User;

use App\Models\User;
use App\Contracts\Dao\User\UserDaoInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDao implements UserDaoInterface
{
    /**
     * Get userId Data
     *
     * @return array
     */
    public function getUserId(){
        $result = User::select('id','name')->get();
        if ($result) {
            return response()->json($result, 200);
        } else {
            return response()->json('No Data', 404);
        }
    }
}