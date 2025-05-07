@extends('layouts.master')

@section('main-content')
    <div class="container py-5">
        <h2>Phương thức thanh toán</h2>

        <form action="{{ route('booking.confirmation') }}" method="POST">
            @csrf
            <div class="mb-3">
                <select name="payment_method" class="form-select" required>
                    <option value="">-- Chọn phương thức thanh toán --</option>
                    <option value="cash">Thanh toán khi khám</option>
                    <option value="online">Thanh toán Online (MOMO, VNPAY,...)</option>
                </select>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Xác nhận và đặt lịch</button>
            </div>
        </form>
    </div>
@endsection
