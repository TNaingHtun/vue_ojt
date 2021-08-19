<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostsExport implements WithHeadings,FromCollection
{

    private $postInfo;
    public function __construct($postInfo)
    {
        $this->postInfo = $postInfo;
    }

    public function headings(): array
    {
        return ["Post Title", "Post Description", "Post Expired Date", "Post User"];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        
        Log::info('enter');
        Log::info($this->postInfo);
        $data = $this->postInfo;
        return collect($data);
    }
}
