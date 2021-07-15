<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Contracts\Services\Posts\PostServiceInterface;
use App\Http\Requests\Posts\PostCreateApiRequest;
use App\Http\Requests\Posts\PostUploadRequest;
use App\Services\Validation\PostValidation;
use App\Services\Validation\PostCsvValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostApiController extends Controller
{
    private $postInterface;
    private $postValidation;
    private $postCsvValidation;

    /**
     * Create a new controller instance.
     *
     * @param PostServiceInterface,PostValidation
     * @return void
     */
    public function __construct(PostServiceInterface $postServiceInterface, PostValidation $postValidation,PostCsvValidation $postCsvValidation)
    {
        $this->postInterface = $postServiceInterface;
        $this->postValidation = $postValidation;
        $this->postCsvValidation = $postCsvValidation;
    }

    /**
     * Show Post List
     *
     * @return array
     */
    public function showPostList()
    {
        $sortDirection = request('sort_direction', 'desc');
        $sortField = request('sort_field', 'title');
        $postList = $this->postInterface->getPostListPagination($sortField, $sortDirection);
        return $postList;
    }

    /**
     * Search List
     *
     * @param searchValue
     * @return array
     */
    public function showSearchPostList($keyword)
    {
        $sortDirection = request('sort_direction', 'desc');
        $sortField = request('sort_field', 'title');
        $postList = $this->postInterface->showSearchPostList($keyword, $sortField, $sortDirection);
        return $postList;
    }

    /**
     * Get Post List
     *
     * @param postid
     * @return array
     */
    public function showPostListById($postId)
    {
        $post = $this->postInterface->getPostListById($postId);
        return $post;
    }

    /**
     * Create post
     *
     * @param request
     * @return array
     */
    public function createPost(Request $request)
    {
        Log::info('request data');
        Log::info($request->toArray());
        $post_validation = $this->postValidation->validationForPost($request);
        if (!empty($post_validation)) {
            Log::info('duplicate title');
            return response(
                [
                    'status' => 422,
                    'data' => [],
                    'errors' => $post_validation
                ]
            );
        }

        $post = $this->postInterface->storeApiPost($request);
        Log::info('success data');
        Log::info($post->toArray());
        if ($post) {
            $data[] = $post;
            return response(
                [
                    'status' => 200,
                    'data' => $data,
                    'success_message' => 'post create successful'
                ]
            );
        }
    }

    /**
     * Update post
     *
     * @param request,postid
     * @return array
     */
    public function updatePostListById(Request $request, $id)
    {
        $post_info = $request;
        //to confirm this action is update action in common file
        $post_info["post_update"] = 1;
        Log::info($request);

        $post_validation = $this->postValidation->validationForPost($post_info);
        if ($post_validation) {
            return response(
                [
                    'status' => 422,
                    'data' => [],
                    'errors' => $post_validation
                ]
            );
        }

        $post = $this->postInterface->updatedApiPostById($request, $id);
        if ($post) {
            $data[] = $post;
            return response(
                [
                    'status' => 200,
                    'data' => $data,
                    'success_message' => 'post create successful'
                ]
            );
        }
    }

    /**
     * delete post
     *
     * @param postid
     * @return array
     */
    public function deletePostListById($postId)
    {
        $msg = $this->postInterface->deletePostById($postId, 1);
        return $msg;
    }

    /**
     * Show Post List
     *
     * @return array
     */
    public function getPostList()
    {
        $postList = $this->postInterface->getPostList();
        return response()->json($postList);
    }

    public function uploadCSVPost(PostUploadRequest $request)
    {
        // validation for request values
        $validated = $request->validated();
        Log::info($validated);

        $csv_validated = $this->postCsvValidation->validationForPost($validated);
        Log::info($csv_validated);
        
        if (!empty($csv_validated)) {
            return response()->json(['error' => $csv_validated], JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $content = $this->postInterface->uploadCSVPost($validated);
            return response()->json(['message' => $content['message']]);
        }
    }
}
