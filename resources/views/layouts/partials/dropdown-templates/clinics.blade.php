 <template id="dropdown-template-clinics">
     <div class="row py-4">
         <div class="col-md-4">
             <h6 class="dropdown-header">Bệnh viện</h6>
             <div class="dropdown-divider"></div>
             <div class="clinic-list">
                 @foreach ($dropdownData['clinics']['hospitals'] as $hospital)
                     <a href="/clinic/{{ $hospital->id }}"
                         class="clinic-item d-flex align-items-center mb-2">
                         <div class="clinic-logo me-2">
                             @if ($hospital->photo)
                                 <img src="{{ $hospital->photo }}" alt="{{ $hospital->name }}"
                                     class="img-fluid clinic-thumbnail">
                             @else
                                 <div class="clinic-thumbnail-placeholder">
                                     <i class="fas fa-hospital"></i>
                                 </div>
                             @endif
                         </div>
                         <span class="clinic-name">{{ $hospital->name }}</span>
                     </a>
                 @endforeach

                 <a href="/clinics?type=hospital" class="item-viewall dropdown-item view-all mt-2">
                     <i class="fas fa-angle-right me-1"></i> Xem tất cả
                     ({{ $dropdownData['clinics']['totalHospitals'] }})
                 </a>
             </div>
         </div>
         <div class="col-md-4">
             <h6 class="dropdown-header">Phòng khám</h6>
             <div class="dropdown-divider"></div>
             <div class="clinic-list">
                 @foreach ($dropdownData['clinics']['clinics'] as $clinic)
                     <a href="/clinic/{{ $clinic->id }}"
                         class="clinic-item d-flex align-items-center mb-2">
                         <div class="clinic-logo me-2">
                             @if ($clinic->photo)
                                 <img src="{{ $clinic->photo }}" alt="{{ $clinic->name }}"
                                     class="img-fluid clinic-thumbnail">
                             @else
                                 <div class="clinic-thumbnail-placeholder">
                                     <i class="fas fa-clinic-medical"></i>
                                 </div>
                             @endif
                         </div>
                         <span class="clinic-name">{{ $clinic->name }}</span>
                     </a>
                 @endforeach

                 <a href="/clinics?type=clinic" class="item-viewall dropdown-item view-all mt-2">
                     <i class="fas fa-angle-right me-1"></i> Xem tất cả
                     ({{ $dropdownData['clinics']['totalClinics'] }})
                 </a>
             </div>

         </div>
         <div class="col-md-4">
             <div class="dropdown-image-container">
                 <img src="https://plus.unsplash.com/premium_photo-1682130157004-057c137d96d5?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                     alt="Bệnh viện và phòng khám" class="dropdown-image">
                 <div class="dropdown-cta">
                     <p>Tìm kiếm bệnh viện và phòng khám phù hợp với nhu cầu của bạn</p>
                     <a href="/clinics" class="btn btn-primary btn-sm">Xem tất cả</a>
                 </div>
             </div>
         </div>
     </div>
 </template>
