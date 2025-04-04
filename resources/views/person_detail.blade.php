@extends('layouts.main')

@section('content')

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>{{ $jobName ?? 'รายละเอียดบุคลากร' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/person.css') }}" type="text/css" />

    <button onclick="history.back()" style="margin: 1rem; padding: 0.6rem 1.2rem; background-color: #6a1b9a; color: white; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
        ← กลับหน้าก่อนหน้า
    </button>
</head>

<body>

    <div class="container">

        <div class="header">
            {{ $jobName }}
        </div>
        <table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ นามสกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($persons as $index => $person)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <a href="{{ url('/person_detail/persons') }}?id={{ $person->tunit_id }}&budget={{ $person->budget }}">
                            {{ $person->name ?? '-' }}
                        </a>

                    </td>

                    <td>{{ $person->position ?? '-' }}</td>
                    <td>
                        <a href="{{ url('/person_detail/person') }}?id={{ $person->id }}" class="detail-button">ดูรายละเอียด</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="not-found">ไม่พบข้อมูลบุคลากร</td>
                </tr>
                @endforelse

                @if(count($persons) > 0)
                <tr class="total">
                    <td></td>
                    <td>รวม</td> {{-- อยู่ตรงกับ "ชื่อ นามสกุล" --}}
                    <td>{{ count($persons) }}</td>
                    <td></td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

</body>

</html>
