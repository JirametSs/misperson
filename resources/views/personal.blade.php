@extends('layouts.main')

@section('content')

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>รายละเอียดบุคคล</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/person.css') }}" type="text/css" />


</head>

<body>

    <button onclick="history.back()" style="margin: 1rem; padding: 0.6rem 1.2rem; background-color: #6a1b9a; color: white; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
        ← กลับหน้าก่อนหน้า
    </button>

    <div class="container">
        <div class="header">
            รายละเอียดบุคคล
        </div>

        <table>
            <tr>
                <th>ชื่อ-นามสกุล</th>
                <td>{{ $person->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>ตำแหน่ง</th>
                <td>{{ $person->position ?? '-' }}</td>

            </tr>
            <tr>
                <th>ประเภท</th>
                <td>{{ $person->employee_type ?? '-' }}</td>
            </tr>

            <tr>
                <th>หน่วยงาน</th>
                <td>{{ $person->unit_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>ปฏิบัติที่</th>
            <td>{{ $person->job_type ?? '-' }}</td>
        </tr>
            <tr>
                <th>เบอร์โทร</th>
                <td>{{ $person->tel ?? '-' }}</td>
            </tr>
            <tr>
                <th>อีเมล</th>
                <td>{{ $person->email_cmu ?? '-' }}</td>
            </tr>
        </table>
    </div>

</body>

</html>
