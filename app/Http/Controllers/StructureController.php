<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StructureController extends Controller
{
    public function index()
    {
        $structures = DB::table('tbudget_qf')
            ->leftJoin('temployee_qf', 'temployee_qf.budget', '=', 'tbudget_qf.id')
            ->select(
                'tbudget_qf.id as tbudget_id',
                'tbudget_qf.name as budget_name',
                DB::raw('COUNT(temployee_qf.idx) as total'),
            )
            ->groupBy('tbudget_qf.id', 'tbudget_qf.name')
            ->orderByDesc('total')
            ->get();

        $structures = $structures->filter(fn($item) => $item->total > 0)->values();

        $sumTotal = $structures->sum('total');

        $structures = $structures->map(function ($item) use ($sumTotal) {
            $item->percentage = $sumTotal > 0 ? round(($item->total / $sumTotal) * 100, 2) : 0;
            return $item;
        });

        $labels = $structures->pluck('budget_name')->map(fn($name) => $name ?? 'ไม่พบงบประมาณ');
        $data = $structures->pluck('total');
        $percentages = $structures->pluck('percentage');

        return view('structure', compact('structures', 'sumTotal', 'labels', 'data', 'percentages'));
    }
}
