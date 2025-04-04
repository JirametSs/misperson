<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tjob;
use App\Models\Tunit;
use App\Models\Tbudget;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $tunit_id = $request->query('id');
        $budgetId = $request->query('budget');

        if (!$tunit_id || !$budgetId) {
            abort(404, 'รหัสหน่วยงานหรือรหัสงบประมาณไม่ถูกต้อง');
        }

        $unitName = Tunit::find($tunit_id)?->name ?? 'ไม่พบหน่วยงาน';
        $budgetName = Tbudget::find($budgetId)?->name ?? 'ไม่พบข้อมูลงบประมาณ';

        $persons = DB::table('temployee_qf')
            ->leftJoin('tprefix', 'temployee_qf.prefix_id', '=', 'tprefix.id')
            ->leftJoin('tposition as tp1', 'temployee_qf.Tpos_id', '=', 'tp1.id')
            ->leftJoin('tposition as tp2', 'temployee_qf.Tpos_id', '=', 'tp2.old_pos_id')
            ->leftJoin('tunit', 'temployee_qf.T_worku_id', '=', 'tunit.id')
            ->leftJoin('tjob', 'temployee_qf.T_Work_id', '=', 'tjob.id')
            ->leftJoin('tbudget_qf', 'temployee_qf.budget', '=', 'tbudget_qf.id')
            ->select(
                'temployee_qf.idx as id',
                DB::raw("CONCAT(COALESCE(tprefix.short_name, ''), temployee_qf.fname, ' ', temployee_qf.lname) AS full_name"),
                DB::raw("COALESCE(tp1.tcer_pos_name, tp2.tcer_pos_name, tp1.name, tp2.name, 'ไม่ระบุตำแหน่ง') as position"),
                'tbudget_qf.EmployeeType as employee_type', // ✅ ประเภท
                'tunit.name as unit_name',                  // ✅ หน่วยงาน
                'tjob.name as job_name',                    // ✅ ปฏิบัติราชการที่
                'temployee_qf.tel',
                'temployee_qf.email_cmu'
            )
            ->where('temployee_qf.Tunit_id', $tunit_id)
            ->where('temployee_qf.budget', $budgetId)
            ->orderBy('temployee_qf.fname')
            ->get();

        return view('person', compact('persons', 'unitName', 'budgetName', 'tunit_id', 'budgetId'));
    }

    public function byJob(Request $request)
    {
        $jobId = $request->query('id');
        $budgetId = $request->query('budget');

        if (!$jobId || !$budgetId) {
            abort(404, 'รหัสประเภทการจ้างหรือรหัสงบประมาณไม่ถูกต้อง');
        }

        $jobName = Tjob::find($jobId)?->name ?? 'ไม่พบประเภทการจ้าง';

        $persons = DB::table('temployee_qf')
            ->leftJoin('tprefix', 'temployee_qf.prefix_id', '=', 'tprefix.id')
            ->leftJoin('tposition as tp1', 'temployee_qf.Tpos_id', '=', 'tp1.id')
            ->leftJoin('tposition as tp2', 'temployee_qf.Tpos_id', '=', 'tp2.old_pos_id')
            ->leftJoin('tunit', 'temployee_qf.Tunit_id', '=', 'tunit.id')
            ->leftJoin('tjob', 'temployee_qf.T_Work_id', '=', 'tjob.id')
            ->select(
                'temployee_qf.idx as id',
                DB::raw("CONCAT(COALESCE(tprefix.short_name, ''), temployee_qf.fname, ' ', temployee_qf.lname) AS full_name"),
                DB::raw("COALESCE(tp1.tcer_pos_name, tp2.tcer_pos_name, tp1.name, tp2.name, 'ไม่ระบุตำแหน่ง') as position"),
                'tunit.name as unit_name',
                'tjob.name as job_name',
                'temployee_qf.tel',
                'temployee_qf.email_cmu'
            )
            ->where('temployee_qf.TJob_id', $jobId)
            ->where('temployee_qf.budget', $budgetId)
            ->orderBy('temployee_qf.fname')
            ->get();

        return view('person_detail', compact('persons', 'jobName', 'budgetId'));
    }

    public function show($id)
    {
        $person = DB::table('temployee_qf')
            ->leftJoin('tprefix', 'temployee_qf.prefix_id', '=', 'tprefix.id')
            ->leftJoin('tposition as tp1', 'temployee_qf.Tpos_id', '=', 'tp1.id')
            ->leftJoin('tposition as tp2', 'temployee_qf.Tpos_id', '=', 'tp2.old_pos_id')
            ->leftJoin('tunit', 'temployee_qf.Tunit_id', '=', 'tunit.id')
            ->leftJoin('tjob', 'temployee_qf.T_Work_id', '=', 'tjob.id')
            ->select(
                DB::raw("CONCAT(COALESCE(tprefix.short_name, ''), temployee_qf.fname, ' ', temployee_qf.lname) AS full_name"),
                DB::raw("COALESCE(tp1.tcer_pos_name, tp2.tcer_pos_name, tp1.name, tp2.name, 'ไม่ระบุตำแหน่ง') as position"),
                'tunit.name as unit_name',
                'tjob.name as job_name',
                'temployee_qf.tel',
                'temployee_qf.email_cmu'
            )
            ->where('temployee_qf.idx', $id)
            ->firstOrFail();

        return view('person_show', compact('person'));
    }
}
