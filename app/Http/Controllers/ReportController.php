<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OrderExport;
use Illuminate\Support\Carbon;
use App\Utils\Traits\ResponseTrait;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    use ResponseTrait;

    public function index() {
        $files = Storage::disk('public')->files('reports');

        $results = [];
        for ($i=0; $i < $files; $i++) {
            $filename = explode('/', $files[$i]);
            $results[$i]['filename'] = $filename[1];
            $results[$i]['download_link'] = url('storage/' . $files[$i]);
            return $this->responseSuccess('get list generated report success', $results);
        }
    }

    public function export() {
        $filename = 'reports/report_' . Carbon::now()->format('dmYHis') . '.xlsx';
        (new OrderExport)->store($filename, 'public');
        return $this->responseSuccess('generate report success');
    }
}
