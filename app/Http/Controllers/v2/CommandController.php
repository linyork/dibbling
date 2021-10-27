<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\CommandModel;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $command = new CommandModel;
            $command->command = $request->input('command');
            $command->save();
            $result = true;
        }
        catch (\Exception $e)
        {
            $result = $e;
        }
        return response()->json($result);
    }
}
