<?php

namespace App\Contracts\Services\Posts;

use Illuminate\Http\Request;


interface PostServiceInterface
{

    /**
     * Get post Data
     *
     * @param sortField,sortDirection
     * @return array
     */
    public function getPostListPagination($sortField,$sortDirection);

    /**
     * Get search post Data
     *
     * @param keyword,sortField,sortDirection
     * @return array
     */
    public function showSearchPostList($keyword,$sortField,$sortDirection);

    /**
     * Get post Data
     *
     * @param postid
     * @return array
     */
    public function getPostListById($postId);

    /**
     * create post
     *
     * @param validatedData
     * @return array
     */
    public function storeApiPost($validated);

    /**
     * update post Data
     *
     * @param request,postid
     * @return array
     */
    public function updatedApiPostById(Request $request, $id);

    /**
     * Get post Data
     *
     * @param postid,userid
     * @return array
     */
    public function deletePostById($id, $deletedUserId);

    /**
     * Get post Data
     *
     * @return array
     */
    public function getPostList();
    
    /**
     * Create Post with CSV Data
     *
     * @return array
     */
    public function uploadCSVPost($validated);
}
