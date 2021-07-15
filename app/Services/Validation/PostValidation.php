<?php

namespace App\Services\Validation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Contracts\Dao\Posts\PostDaoInterface;
use Illuminate\Support\Facades\Log;

class PostValidation
{
    private $postInterface;

    /**
     * Create a new service instance.
     *
     * @param PostDaoInterface
     * @return void
     */
    public function __construct(PostDaoInterface $postDaoInterface)
    {
        $this->postInterface = $postDaoInterface;
    }

    /**
     * Create validation Data
     *
     * @param post info
     * @return array
     */
    public function validationForPost($post_info)
    {
        $validator = Validator::make($post_info->all(), [
            'tile' => 'required',
            'description' => 'required'
        ]);

        $validation_error = array();
        $errors = $validator->errors();
        $errors = $errors->toArray();

        if(!empty($post_info["post_update"])){
            $post_title = Post::select('title')
            ->where('title', $post_info['title'])
            ->where('id','!=', $post_info['id'])
            ->first();
            
            Log::info('duplicated data');
            Log::info($post_title);
            if(!empty($post_title)){
                $post_title_array = array('post_title' => ['status' => 442, 'error_message' => 'Post title is already existed']);
                $validation_error = array_merge($validation_error, $post_title_array);
            }
        }else{
            $post_title = Post::select('title')
            ->where('title', $post_info['title'])
            ->first();
            
            Log::info('duplicated data');
            Log::info($post_title);
            if (!empty($post_title)) {
                $post_title_array = array('post_title' => ['status' => 442, 'error_message' => 'Post title is already existed']);
                $validation_error = array_merge($validation_error, $post_title_array);
            }
        }
        Log::info('validated Date');
        Log::info($validation_error);
        return $validation_error;
    }
}
