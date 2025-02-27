@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Danh sách lịch khám của bác sĩ</h2>

        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#pending">Chờ xác nhận</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#confirmed">Đã xác nhận</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#completed">Hoàn thành</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#canceled">Đã hủy</a></li>
        </ul>

        <div class="tab-content mt-3">
            @foreach (['pending' => 'Chờ xác nhận', 'confirmed' => 'Đã xác nhận', 'completed' => 'Hoàn thành', 'canceled' => 'Đã hủy'] as $status => $label)
                <div id="{{ $status }}" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}">
                    <table class="table-bordered table">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Giờ</th>
                                <th>Bệnh nhân</th>
                                <th>Ghi chú</th>
                                <th>Loại tư vấn</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments->where('status', $status) as $appointment)
                                <tr>
                                    <td>{{ $appointment->date->format('d/m/Y') }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->user->name }}</td>
                                    <td>{{ $appointment->notes ?? 'Không có' }}</td>
                                    <td>{{ ucfirst($appointment->consultation_type) }}</td>
                                    <td><span class="badge badge-info">{{ ucfirst($appointment->status) }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
@endsection
