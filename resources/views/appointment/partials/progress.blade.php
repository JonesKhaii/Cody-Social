<div class="step-progress mb-5">
    <div class="steps d-flex justify-content-between">
        <div class="step {{ request()->routeIs('booking.specialty') ? 'active' : '' }}">
            <div class="circle">1</div>
            <div class="label">Chuyên khoa</div>
        </div>
        <div class="step {{ request()->routeIs('booking.service') ? 'active' : '' }}">
            <div class="circle">2</div>
            <div class="label">Bác sĩ</div>
        </div>
        <div class="step {{ request()->routeIs('booking.datetime') ? 'active' : '' }}">
            <div class="circle">3</div>
            <div class="label">Ngày & Giờ</div>
        </div>
        <div class="step {{ request()->routeIs('booking.information') ? 'active' : '' }}">
            <div class="circle">4</div>
            <div class="label">Thông tin</div>
        </div>
        <div class="step {{ request()->routeIs('booking.payment') ? 'active' : '' }}">
            <div class="circle">5</div>
            <div class="label">Thanh toán</div>
        </div>
        <div class="step {{ request()->routeIs('booking.confirmation') ? 'active' : '' }}">
            <div class="circle">6</div>
            <div class="label">Xác nhận</div>
        </div>
    </div>
</div>
