<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title m-0">Lịch hẹn của bạn</h2>
        <div>
            <button class="btn btn-light btn-sm me-2">Lọc</button>
            <button class="btn btn-light btn-sm">Xuất</button>
        </div>
    </div>

    <div class="card-body">
        @if ($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table-hover table">
                    <thead>
                        <tr>
                            <th>Bệnh nhân</th>
                            <th>Thời gian</th>
                            <th>Hình thức khám</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td>
                                    <div>{{ $appointment->user->name }}</div>
                                    <span
                                        class="text-muted d-block">{{ $appointment->user->email }}</span>
                                    <span
                                        class="text-muted d-block">{{ $appointment->user->phone }}</span>
                                </td>
                                <td>
                                    <div>
                                        {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                                    </div>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</small>
                                </td>
                                <td>
                                    @switch($appointment->consultation_type)
                                        @case('Online')
                                            <span class="badge text-bg-info">Trực tuyến</span>
                                        @break

                                        @case('Offline')
                                            <span class="badge text-bg-primary">Tại phòng khám</span>
                                        @break

                                        @case('At Home')
                                            <span class="badge text-bg-success">Tại nhà</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($appointment->status)
                                        @case('Chờ duyệt')
                                            <span
                                                class="badge text-bg-warning">{{ $appointment->status }}</span>
                                        @break

                                        @case('Sắp tới')
                                            <span
                                                class="badge text-bg-info">{{ $appointment->status }}</span>
                                        @break

                                        @case('Hoàn thành')
                                            <span
                                                class="badge text-bg-success">{{ $appointment->status }}</span>
                                        @break

                                        @case('Đã Huỷ')
                                            <span
                                                class="badge text-bg-danger">{{ $appointment->status }}</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <button type="button"
                                        class="btn btn-info btn-sm view-appointment"
                                        data-id="{{ $appointment->id }}"
                                        data-patient-name="{{ $appointment->user->name }}"
                                        data-patient-email="{{ $appointment->user->email }}"
                                        data-patient-phone="{{ $appointment->user->phone }}"
                                        data-date="{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}"
                                        data-time="{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}"
                                        data-type="{{ $appointment->consultation_type }}"
                                        data-status="{{ $appointment->status }}"
                                        data-approval="{{ $appointment->approval_status }}"
                                        data-notes="{{ $appointment->notes ?? 'Không có ghi chú' }}"
                                        data-result="{{ $appointment->result ?? '' }}">
                                        Xem
                                    </button>
                                </td>
                                <td>
                                    @if ($appointment->status === 'Sắp tới' && $appointment->approval_status === 'Chấp nhận')
                                        <form method="POST"
                                            action="{{ route('doctor.appointments.complete', ['id' => $appointment->id]) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="btn btn-primary btn-sm">Hoàn thành</button>
                                        </form>

                                        <form method="POST"
                                            action="{{ route('doctor.appointments.cancel', ['id' => $appointment->id]) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="button"
                                                class="btn btn-danger btn-sm cancel-appointment-btn">Hủy</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-5 text-center">
                <p class="text-muted mb-0">Chưa có lịch hẹn nào được đặt</p>
            </div>
        @endif
    </div>
</div>
