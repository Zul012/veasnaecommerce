@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
      <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($products)>0)
        <table class="table table-bordered table-hover" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Category</th>
              <th>Featured</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Size</th>
              <th>Condition</th>
              <th>Brand</th>
              <th>Stock</th>
              <th>Photo</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($products as $product)
              @php
              $sub_cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
              // dd($sub_cat_info);
              $brands=DB::table('brands')->select('title')->where('id',$product->brand_id)->get();
              @endphp
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->title}}</td>
                    <td>
                      @if(isset($product->cat_info) && is_array($product->cat_info))
                        {{$product->cat_info['title']}}
                      @elseif(isset($product->cat_info) && is_object($product->cat_info))
                        {{$product->cat_info->title}}
                      @else
                        N/A
                      @endif
                      <sub>
                          @if(isset($product->sub_cat_info) && $product->sub_cat_info)
                            {{$product->sub_cat_info->title}}
                          @endif
                      </sub>
                    </td>
                    <td>{{(($product->is_featured==1)? 'Yes': 'No')}}</td>
                    <td>${{$product->price}}</td>
                    <td>{{$product->discount ?? 0}}%</td>
                    <td>{{$product->size ?? 'N/A'}}</td>
                    <td>{{$product->condition}}</td>
                    <td>
                      @if($product->brand && $product->brand->title)
                        {{ucfirst($product->brand->title)}}
                      @elseif($brands->isNotEmpty())
                        {{ucfirst($brands->first()->title)}}
                      @else
                        N/A
                      @endif
                    </td>
                    <td>
                      @if($product->stock>0)
                      <span class="badge badge-primary">{{$product->stock}}</span>
                      @else
                      <span class="badge badge-danger">{{$product->stock}}</span>
                      @endif
                    </td>
                    <td>
                        @if($product->photo)
                            @php
                              $photo=explode(',',$product->photo);
                              // dd($photo);
                            @endphp
                            <img src="{{$photo[0]}}" class="img-fluid zoom" style="max-width:80px" alt="{{$product->photo}}">
                        @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                        @endif
                    </td>
                    <td>
                        @if($product->status=='active')
                            <span class="badge badge-success">{{$product->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$product->status}}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('product.edit',$product->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('product.destroy',[$product->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$product->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            {!! $products->appends(['sort' => 'id'])->links() !!}
        </div>
        @else
          <h6 class="text-center">No Products found!!! Please create Product</h6>
        @endif
      </div>
    </div>
</div><!-- Visit 'codeastro' for more projects -->
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      /* Pagination styling */
      .pagination {
          display: flex;
          padding-left: 0;
          list-style: none;
          border-radius: 0.35rem;
      }
      
      .pagination li {
          display: inline;
      }
      
      .pagination li a, .pagination li span {
          position: relative;
          display: block;
          padding: 0.5rem 0.75rem;
          margin-left: -1px;
          line-height: 1.25;
          color: #4e73df;
          background-color: #fff;
          border: 1px solid #dddfeb;
          font-size:10px;
      }
      
      .pagination li.active span {
          z-index: 1;
          color: #fff;
          background-color: #4e73df;
          border-color: #4e73df;
      }

      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#product-dataTable').DataTable({
        "scrollX": false,
        "paging": false,    // Disable DataTables pagination
        "info": false,      // Hide "Showing X of Y entries"
        "columnDefs":[
            {
                "orderable": false,
                "targets": [10,11,12]
            }
        ]
      });

      // Sweet alert

      function deleteData(id){
          
      }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush