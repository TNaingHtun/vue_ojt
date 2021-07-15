<?php

namespace App\Services\Validation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Contracts\Dao\Posts\PostDaoInterface;
use Illuminate\Support\Facades\Log;
use DateTime;

class PostCsvValidation
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
     * @param csv info
     * @return array
     */
    public function validationForPost($csv_info)
    {
        Log::info($csv_info);
        $path =  $csv_info['csv_file']->getRealPath();
        $csv_data = array_map('str_getcsv', file($path));

        $validation_error = array();
        // save post to Database accoding to csv row
        for ($index = 1; $index < count($csv_data); $index++) {
            Log::info("CSV header row");
            Log::info($csv_data[$index]);
            $row = $csv_data[$index];
            Log::info("Row data");
            Log::info($row);

            if (count($row) >= 4) {
                try {
                    if ($row[0] == "") {
                        $content = array(
                            'isUploaded' => false,
                            'message' => 'Row number (' . ($index) . ') title is required.'
                        );
                        array_push($validation_error, $content);
                        // return $content;
                    }

                    $post_title = Post::select('title')
                        ->where('title', $row[0])
                        ->first();
                    Log::info('title');
                    Log::info($post_title);
                    if (!empty($post_title)) {
                        $content = array(
                            'isUploaded' => false,
                            'message' => 'Row number (' . ($index) . ') title is duplicated.'
                        );
                        array_push($validation_error, $content);
                        // return $content;
                    }


                    if ($row[1] == "") {
                        $content = array(
                            'isUploaded' => false,
                            'message' => 'Row number (' . ($index) . ') description is required.'
                        );
                        array_push($validation_error, $content);
                        // return $content;
                    }

                    if ($row[2] == "") {
                        $content = array(
                            'isUploaded' => false,
                            'message' => 'Row number (' . ($index) . ') expired date is required.'
                        );
                        array_push($validation_error, $content);
                        // return $content;
                    }
                    $date = $row[2];
                    if (DateTime::createFromFormat('m/d/Y', $date)) {
                        $expiredDate = \Carbon\Carbon::createFromFormat('m/d/Y', $date)
                            ->format('Y-m-d');
                        Log::info('date');
                        Log::info($expiredDate);
                    } else {
                        $content = array(
                            'isUploaded' => false,
                            'message' => 'Row number (' . ($index) . ') date is invalid format.'
                        );
                        array_push($validation_error, $content);
                        // return $content;
                    }


                    if ($row[3] == "") {
                        $content = array(
                            'isUploaded' => false,
                            'message' => 'Row number (' . ($index) . ') user is required.'
                        );
                        array_push($validation_error, $content);
                        // return $content;
                    }
                    Log::info($row[3]);
                    $userIdData = User::select('id')
                        ->where('name', '=', $row[3])
                        ->first();
                    Log::info('id');
                    Log::info($userIdData);
                    if (empty($userIdData)) {
                        $content = array(
                            'isUploaded' => false,
                            'message' => 'Row number (' . ($index) . ') user is not found.'
                        );
                        array_push($validation_error, $content);
                        // return $content;
                    }
                    // return $validation_error;
                } catch (\Illuminate\Database\QueryException $e) {
                    $errCode = $e->errorInfo[1];
                    if ($errCode == 1292) {
                        $content = array(
                            'isUploaded' => false,
                            'message' => 'Row number (' . ($index) . ') date is invalid format.'
                        );
                        array_push($validation_error, $content);
                        return $content;
                    }
                }
            } else {
                // error handling for invalid row.
                $content = array(
                    'isUploaded' => false,
                    'message' => 'Row number (' . ($index) . ') is invalid format.'
                );
                array_push($validation_error, $content);
                return $content;
            }
        }
        Log::info($validation_error);
        return $validation_error;
    }
}
