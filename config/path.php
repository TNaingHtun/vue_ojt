<?php

return [
  'separator' => env('SEPARATOR', '/'),

  'public_tmp' => env('PUBLIC_TMP', 'public/tmp/'),

  'profile' => env('PROFILE', 'profile/'),

  'tmp_path' => env('TMP_PATH', 'tmp/'),

  'profile_app_path' => env('PROFILE_APP_PATH', 'app/'),

  'csv' => env('CSV', 'csv/'),

  //wd_radar_chart - personality result save path
  'user_profile' => 'https://jobscale-dev.s3.ap-northeast-1.amazonaws.com/user_profile/',
];
