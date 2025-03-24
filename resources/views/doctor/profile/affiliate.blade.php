 <!-- Danh sách sản phẩm -->
 <div class="card mb-4 shadow">
     <div class="card-header py-3">
         <h2 class="card-title">Danh sách sản phẩm </h2>
     </div>

     <div class="table-responsive">
         <table class="table-bordered table-hover table" id="product-dataTable" width="100%">
             <thead>
                 <tr>
                     <th>#</th>
                     <th>Tiêu đề</th>
                     <th>Loại</th>
                     <th>Giá</th>
                     <th>Giảm giá</th>
                     <th>Loại</th>
                     <th>Thương hiệu</th>
                     <th>Ảnh</th>
                     <th>Chức năng</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($productss as $product)
                     <tr>
                         <td>{{ $product->id }}</td>
                         <td>{{ $product->title }}</td>
                         <td>{{ optional($product->cat_info)->title }}
                             <sub>{{ optional($product->sub_cat_info)->title ?? '' }}</sub>
                         </td>
                         <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                         <td>{{ $product->discount }}%</td>
                         <td>{{ $product->size }}</td>
                         <td>{{ ucfirst(optional($product->brand)->title) }}</td>
                         <td>
                             @if ($product->photo)
                                 @php
                                     $photo = explode(',', $product->photo);
                                 @endphp
                                 <img src="{{ $photo[0] }}" class="img-fluid zoom"
                                     style="max-width:80px" alt="{{ $product->photo }}">
                             @else
                                 <img src="{{ asset('backend/img/thumbnail-default.jpg') }}"
                                     class="img-fluid" style="max-width:80px" alt="avatar.png">
                             @endif
                         </td>
                         <td>

                             @if ($products->contains('id', $product->id))
                                 <!-- Nút tạo tiếp thị đã có -->
                                 <button class="btn btn-secondary btn-sm"
                                     id="copy-link-btn-{{ $product->id }}"
                                     data-id="{{ $product->id }}"
                                     data-slug="{{ $product->slug }}"
                                     data-link="{{ $product->existingLink->product_link }}">
                                     <i class="fa-solid fa-link"></i> Đã liên kết
                                 </button>
                             @else
                                 <!-- Nút tạo tiếp thị chưa có -->
                                 <button class="btn btn-success btn-sm create-affiliate-btn"
                                     id="generate-affiliate-link"
                                     data-id="{{ $product->id }}"
                                     data-slug="{{ $product->slug }}"
                                     title="Tạo tiếp thị">
                                     <i class="fa-solid fa-link"></i> Tạo tiếp thị
                                 </button>
                             @endif

                         </td>
                     </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
 <!-- Danh sách sản phẩm đã tiếp thị -->
 <div class="card">
     <div class="card-header">
         <h2 class="card-title">Sản phẩm đã có trong danh sách tiếp thị </h2>
         <div class="card-header-actions">
             <button class="btn btn-primary" id="open-add-product-modal"
                 style="margin-left: auto;">
                 <i class="fas fa-plus"></i>
                 Thêm sản phẩm mới
             </button>
         </div>
     </div>
     <div class="card-body">
         @if ($products->isEmpty())
             <div class="py-5 text-center">
                 <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                 <h3 class="text-muted">Chưa có sản phẩm tiếp thị</h3>
                 <p class="text-secondary mb-4">Thêm sản phẩm để bắt đầu kiếm thêm thu nhập</p>
             </div>
         @else
             <div class="table-responsive">
                 <table class="table-bordered table-hover table" id="affiliate-product-dataTable"
                     width="100%">
                     <thead>
                         <tr>
                             <th>Ảnh Sản Phẩm</th>
                             <th>Tên Sản Phẩm</th>
                             <th>Giá</th>
                             <th>Hành Động</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($products as $product)
                             <tr>
                                 <td>
                                     <img src="{{ asset($product->photo) }}"
                                         alt="{{ $product->title }}" class="product-image">
                                 </td>
                                 <td>{{ $product->title }}</td>
                                 <td>
                                     @if ($product->discount > 0)
                                         <span
                                             class="old-price">{{ number_format($product->price) }}
                                             đ</span>
                                         <span class="discounted-price">
                                             {{ number_format($product->price - ($product->price * $product->discount) / 100) }}
                                             đ
                                         </span>
                                     @else
                                         {{ number_format($product->price) }} đ
                                     @endif
                                 </td>
                                 <td>
                                     <!-- Nút xóa sản phẩm -->
                                     <form action="" method="POST" class="delete-form">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit"
                                             class="btn btn-danger btn-sm delete-btn">
                                             <i class="fas fa-trash"></i> Xóa
                                         </button>
                                     </form>
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         @endif
     </div>
 </div>
