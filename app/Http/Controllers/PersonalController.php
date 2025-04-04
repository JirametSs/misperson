<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalController extends Controller
{
    public function show(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            abort(404, 'ไม่พบรหัสบุคลากร');
        }

        $person = DB::table('temployee_qf')
            ->leftJoin('tprefix', 'temployee_qf.prefix_id', '=', 'tprefix.id')
            ->leftJoin('tposition as tp1', 'temployee_qf.Tpos_id', '=', 'tp1.id')
            ->leftJoin('tposition as tp2', 'temployee_qf.Tpos_id', '=', 'tp2.old_pos_id')
            ->leftJoin('tunit', 'temployee_qf.T_Worku_id', '=', 'tunit.id')
            ->leftJoin('tjob', 'temployee_qf.T_Work_id', '=', 'tjob.id')
            ->leftJoin('tbudget_qf', 'temployee_qf.budget', '=', 'tbudget_qf.id')
            ->select(
                DB::raw("CONCAT(COALESCE(tprefix.short_name, ''), ' ', temployee_qf.fname, ' ', temployee_qf.lname) as name"),
                DB::raw("COALESCE(tp1.tcer_pos_name, tp2.tcer_pos_name, tp1.name, tp2.name, 'ไม่ระบุตำแหน่ง') as position"),
                'temployee_qf.budget',
                'tunit.name as unit_name',
                'tjob.name as job_type',
                'tbudget_qf.EmployeeType as employee_type',
                'temployee_qf.email_cmu',
                'temployee_qf.tel',
                'temployee_qf.birth_date'
            )
            ->where('temployee_qf.idx', $id)
            ->first();

        if (!$person) {
            abort(404, 'ไม่พบข้อมูลบุคคล');
        }

        return view('personal', compact('person'));
    }
}
