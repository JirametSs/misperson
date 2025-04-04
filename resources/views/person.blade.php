@extends('layouts.main')

@section('content')

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายชื่อบุคลากร</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/persons.css') }}" type="text/css" />

</head>
<div class="container">
<button onclick="history.back()" style="margin: 1rem; padding: 0.6rem 1.2rem; background-color: #6a1b9a; color: white; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
    ← กลับหน้าก่อนหน้า
</button
    <div class="wrapper">
        <h2>
            รายชื่อบุคลากร<br>
            หน่วยงาน: {{ $unitName }} | งบประมาณ: {{ $budgetName }}
        </h2>

        <div class="box">
            <div class="box-content">
                <table>
                    <thead>
                        <tr>
                            <th>ชื่อ-นามสกุล</th>
                            <th>ตำแหน่ง</th>
                            <th>ประเภท</th>
                            <th>ปฏิบัติราชการที่</th>
                            <th>หน่วยงานปฏิบัติ</th>
                            <th>โทรศัพท์</th>
                            <th>อีเมล</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($persons as $person)
                            <tr>
                                {{-- ชื่อ-นามสกุล --}}
                                <td>{{ $person->full_name ?? '-' }}</td>

                                {{-- ตำแหน่ง --}}
                                <td>{{ $person->position ?? '-' }}</td>

                                {{-- ประเภทการจ้าง --}}
                                <td>{{ $person->employee_type ?? '-' }}</td>

                                {{-- ปฏิบัติราชการที่ --}}
                                <td>{{ $person->job_name ?? '-' }}</td>

                                {{-- หน่วยงานปฏิบัติ --}}
                                <td>{{ $person->unit_name ?? '-' }}</td>

                                {{-- โทรศัพท์ --}}
                                <td>{{ $person->tel ?? '-' }}</td>

                                {{-- อีเมล --}}
                                <td>{{ $person->email_cmu ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

