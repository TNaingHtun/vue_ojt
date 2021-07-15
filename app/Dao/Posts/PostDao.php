<?php

namespace App\Dao\Posts;

use App\Models\Post;
use App\Models\User;
use App\Contracts\Dao\Posts\PostDaoInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;

use function PHPUnit\Framework\isEmpty;

class PostDao implements PostDaoInterface
{
    //Api
    /**
     * Get Post Data
     *
     * @param sortField,sortDirection
     * @return array
     */
    public function getPostListPagination($sortField, $sortDirection)
    {
        $postList = DB::table('posts as post')
            ->join('users as created_user', 'post.created_user_id', '=', 'created_user.id')
            ->join('users as updated_user', 'post.updated_user_id', '=', 'updated_user.id')
            ->select('post.*', 'created_user.name as created_user', 'updated_user.name as updated_user')
            ->whereNull('post.deleted_at')
            ->orderBy($sortField, $sortDirection)
            ->paginate(5);
        return $postList;
    }

    /**
     * Get Search Data
     *
     * @param keyword,sortField,sortDirection
     * @return array
     */
    public function showSearchPostList($keyword, $sortField, $sortDirection)
    {
        $postList = DB::table('posts as post')
            ->join('users as created_user', 'post.created_user_id', '=', 'created_user.id')
            ->join('users as updated_user', 'post.updated_user_id', '=', 'updated_user.id')
            ->select('post.*', 'created_user.name as created_user', 'updated_user.name as updated_user')
            ->where('title', 'LIKE', '%' . $keyword . '%')
            ->orWhere('description', 'LIKE', '%' . $keyword . '%')
            ->orWhere('created_user.name', 'LIKE', '%' . $keyword . '%')
            ->whereNull('post.deleted_at')
            ->orderBy($sortField, $sortDirection)
            ->paginate(5);
        return $postList;
    }

    /**
     * create post
     *
     * @param validatedData
     * @return array
     */
    public function storeApiPost($validated)
    {
        $post = new Post();
        $post->title = $validated['title'];
        $post->description = $validated['description'];
        $post->created_user_id = $validated['created_user_id'];
        $post->updated_user_id = $validated['created_user_id'];
        $post->expired_at = $validated['expired_at'];
        $post->save();
        return $post;
    }

    /**
     * Get post by id
     *
     * @param postId
     * @return array
     */
    public function getPostListById($postId)
    {
        $postList = DB::table('posts as post')
            ->join('users as created_user', 'post.created_user_id', '=', 'created_user.id')
            ->join('users as updated_user', 'post.updated_user_id', '=', 'updated_user.id')
            ->select('post.*', 'created_user.name as created_user', 'created_user.type as created_user_type', 'updated_user.name as updated_user')
            ->whereNull('post.deleted_at')
            ->where('post.id', $postId)
            ->paginate(10);
        return $postList;
    }

    /**
     * update post
     *
     * @param request,postid
     * @return array
     */
    public function updatedApiPostById(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request['title'];
        $post->description = $request['description'];
        $post->status = $request['status'];
        $post->expired_at = $request['expired_at'];
        $post->save();
        return $post;
    }

    /**
     * delete post
     *
     * @param postid,userid
     * @return array
     */
    public function deletePostById($id, $deletedUserId)
    {
        $post = Post::find($id);
        if ($post && $post->status == 1) {
            $post->deleted_user_id = $deletedUserId;
            $post->status = 0;
            $post->save();
            $post->delete();
            return 'Deleted Successfully!';
        }
        return 'Post Not Found!';
    }

    /**
     * Get Post Data
     *
     * @return array
     */
    public function getPostList()
    {
        $postList = DB::table('posts as post')
            ->join('users as created_user', 'post.created_user_id', '=', 'created_user.id')
            ->join('users as updated_user', 'post.updated_user_id', '=', 'updated_user.id')
            ->select('post.*', 'created_user.name as created_user', 'updated_user.name as updated_user')
            ->whereNull('post.deleted_at')
            ->get();
        // dd($postList);
        return $postList;
    }


    /**
     * Create Post with CSV Data
     *
     * @return array
     */
    public function uploadCSVPost($validated)
    {
        $path =  $validated['csv_file']->getRealPath();
        $csv_data = array_map('str_getcsv', file($path));

        // save post to Database accoding to csv row
        for ($index = 1; $index < count($csv_data); $index++) {
            Log::info("CSV row");
            Log::info($csv_data[$index]);
            $row = $csv_data[$index];
            $post = new Post();

            $post->title = $row[0];

            $post->description = $row[1];

            $expiredDate = \Carbon\Carbon::createFromFormat('m/d/Y', $row[2])
                ->format('Y-m-d');
            Log::info('date');
            Log::info($expiredDate);
            $post->expired_at = $expiredDate;

            Log::info($row[3]);
            $userIdData = User::select('id')
                ->where('name', '=', $row[3])
                ->first();
            $userId[] = $userIdData;
            Log::info('id');
            Log::info($userIdData);
            $post->created_user_id = $userId[0]['id'];
            $post->updated_user_id = $userId[0]['id'];
            $post->save();
        }
        $content = array(
            'message' => 'Uploaded Successfully!'
        );
        return $content;
    }
}
