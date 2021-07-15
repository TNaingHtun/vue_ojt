<?php

namespace App\Services\Posts;

use App\Contracts\Dao\Posts\PostDaoInterface;
use App\Contracts\Services\Posts\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostService implements PostServiceInterface
{

    private $postDao;

    /**
     * Create a new service instance.
     *
     * @param PostDaoInterface
     * @return void
     */
    public function __construct(PostDaoInterface $postDao)
    {
        $this->postDao = $postDao;
    }

    //Api
    /**
     * Get Post Data
     *
     * @param sortField,sortDirection
     * @return
     */
    public function getPostListPagination($sortField,$sortDirection)
    {
        return $this->postDao->getPostListPagination($sortField,$sortDirection);
    }

    /**
     * Get Search Data
     *
     * @param keyword,sortField,sortDirection
     * @return
     */
    public function showSearchPostList($keyword,$sortField,$sortDirection)
    {
        return $this->postDao->showSearchPostList($keyword,$sortField,$sortDirection);
    }

    /**
     * create post
     *
     * @param validatedData
     * @return
     */
    public function storeApiPost($validated)
    {
        return $this->postDao->storeApiPost($validated);
    }

    /**
     * Get post by id
     *
     * @param postId
     * @return
     */
    public function getPostListById($postId)
    {
      return $this->postDao->getPostListById($postId); 
    }

    /**
     * update post
     *
     * @param request,postid
     * @return
     */
    public function updatedApiPostById(Request $request, $id){
        return $this->postDao->updatedApiPostById($request, $id);
    }
    

    public function deletePostById($id, $deletedUserId)
    {
        return $this->postDao->deletePostById($id, $deletedUserId);
    }

    /**
     * Get Post Data
     *
     * @return
     */
    public function getPostList(){
        return $this->postDao->getPostList();
    }

    /**
     * Create Post with CSV Data
     *
     * @return
     */
    public function uploadCSVPost($validated){
        return $this->postDao->uploadCSVPost($validated);
    }
}
