<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersondetailController extends Controller
{
    public function index(Request $request)
    {
        $jobId = $request->query('id');
        $budgetId = $request->query('budget');

        if (!$jobId || !$budgetId) {
            abort(404, 'รหัสประเภทการจ้างหรือรหัสงบประมาณไม่ถูกต้อง');
        }

        $jobName = DB::table('tjob')->where('id', $jobId)->value('name');

        $persons = DB::table('temployee_qf')
            ->leftJoin('tprefix', 'temployee_qf.prefix_id', '=', 'tprefix.id')
            ->leftJoin('tposition', 'temployee_qf.Tpos_id', '=', 'tposition.id')
            ->where('temployee_qf.t_work_id', $jobId)
            ->where('temployee_qf.budget', $budgetId)
            ->select(
                'temployee_qf.idx as id',
                DB::raw("CONCAT(COALESCE(tprefix.short_name, ''), ' ', temployee_qf.fname, ' ', temployee_qf.lname) as name"),
                'tposition.name as position',
                'temployee_qf.Tunit_id as tunit_id',
                'temployee_qf.budget'
            )
            ->orderBy('temployee_qf.fname')
            ->get();

        return view('person_detail', compact('jobName', 'persons', 'budgetId'));
    }
}
