<?php

namespace App\Http\Controllers;

use App\Services\ListService;
use Illuminate\Http\Request;

class Timeline extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, ListService $listService)
    {
        try
        {
            $data = [
                'start_date' => $request->post('start_date') ?? date("Y-m-d", strtotime('-3 month')),
                'end_date' => $request->post('end_date') ?? date("Y-m-d"),
                'order' => $request->post('order') ?? '0',
            ];
            $data['list'] = $listService->getTimeline($data);
        }
        catch (\Exception $e)
        {
            $data['error'] = $e;
        }
        return view('timeline', $data);
    }
}
