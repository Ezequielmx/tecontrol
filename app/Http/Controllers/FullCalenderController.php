<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class FullCalenderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Task::where('start', '>=', $request->start)
            ->where('end', '<=', $request->end)->get();


/*
            $data = Task::all()
                    ->where('start', '>=', $request->start)
                    ->where('end', '<=', $request->end);*/

            return response()->json($data);
        }
        return view('admin.full-calender');
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == 'add') {
                $event = Task::create([
                    'title'        =>    $request->title,
                    'start'        =>    $request->start,
                    'end'        =>    $request->end,
                    'color'        =>    $request->color
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Task::find($request->id)->update([
                    'title'        =>    $request->title,
                    'start'        =>    $request->start,
                    'end'        =>    $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Task::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }
}
