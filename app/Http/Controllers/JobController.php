<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return redirect('/')->with('error', 'ไม่พบ id ที่ส่งมา');
        }

        $budget = DB::table('tbudget_qf')->where('id', $id)->first();
        $budgetName = $budget->name ?? 'ไม่พบชื่อ';


        $jobs = DB::table('tjob')
            ->join('temployee_qf', 'tjob.id', '=', 'temployee_qf.t_work_id')
            ->where('temployee_qf.budget', $id)
            ->select('tjob.id as job_id', 'tjob.name as job_name', DB::raw('COUNT(temployee_qf.idx) as total'))
            ->groupBy('tjob.id', 'tjob.name')
            ->orderByDesc('total')
            ->get();

        $allCount = $jobs->sum('total');

        $chartLabels = $jobs->pluck('job_name')->toArray();
        $chartData = $jobs->pluck('total')->toArray();

        $chartItems = $jobs->map(function ($item) {
            return [
                'label' => $item->job_name,
                'value' => $item->total
            ];
        });

        $budgetId = $id;

        return view('job', compact('jobs', 'allCount', 'budgetName', 'chartLabels', 'chartData', 'chartItems', 'id', 'budgetId'));
    }
}
