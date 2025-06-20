@extends('frontend.layouts.master')
@section('title','Ecommerce Laravel || HOME PAGE')

@push('styles')
<style>
    /* Quick Shop Modal */
    .modal-content {
        border-radius: 8px;
    }
    
    .modal-header {
        border-bottom: 1px solid #eee;
    }
    
    .modal-title {
        font-weight: 600;
        color: #222;
    }
    
    .quick-shop-main-image {
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eee;
        border-radius: 8px;
    }
    
    .quick-shop-main-image img {
        max-height: 280px;
        object-fit: contain;
    }
    
    .current-price {
        font-size: 24px;
        font-weight: 600;
        color: #F7941D;
    }
    
    .original-price {
        font-size: 18px;
        color: #999;
        margin-left: 10px;
    }
    
    .discount-badge {
        background: #F7941D;
        color: #fff;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 14px;
        margin-left: 10px;
    }
    
    .stock-info .in-stock {
        color: #28a745;
    }
    
    .stock-info .out-of-stock {
        color: #dc3545;
    }
    
    .modal-footer {
        border-top: 1px solid #eee;
    }
    
    /* Product cards */
    .single-product {
        transition: all 0.3s;
        margin-bottom: 20px;
    }
    
    .single-product:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    /* Custom Pagination Styles */
    .pagination-container {
        margin-top: 30px;
        margin-bottom: 15px;
        display: flex;
        justify-content: center;
    }
    
    .custom-pagination .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
        justify-content: center;
    }
    
    .custom-pagination .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    
    .custom-pagination .page-item:last-child .page-link {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
    
    .custom-pagination .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: #F7941D;
        border-color: #F7941D;
    }
    
    .custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    .custom-pagination .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #F7941D;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    
    .custom-pagination .page-link:hover {
        z-index: 2;
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    .custom-pagination .page-link:focus {
        z-index: 3;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(247, 148, 29, 0.25);
    }
    
    /* Previous/Next Buttons */
    .custom-pagination .page-item:first-child .page-link,
    .custom-pagination .page-item:last-child .page-link {
        font-weight: 600;
    }
    
    /* Mobile Responsive Pagination */
    @media only screen and (max-width: 767px) {
        .custom-pagination .page-link {
            padding: 6px 12px;
            font-size: 13px;
        }
        
        .custom-pagination .page-item {
            margin: 0 2px;
        }
    }

    /* Featured Products styling */
    .midium-banner {
        padding: 50px 0;
    }
    
    .midium-banner .single-banner {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
    }
    
    .midium-banner .single-banner:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        transform: translateY(-5px);
    }
    
    .midium-banner .single-banner img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: all 0.4s ease;
    }
    
    .midium-banner .single-banner:hover img {
        transform: scale(1.05);
    }
    
    .midium-banner .content {
        position: absolute;
        left: 0;
        bottom: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        padding: 20px;
        text-align: center;
    }
    
    .midium-banner .content p {
        color: #fff;
        font-weight: 500;
        margin-bottom: 5px;
        font-size: 16px;
        text-transform: uppercase;
    }
    
    .midium-banner .content h3 {
        color: #fff;
        margin-bottom: 15px;
        font-size: 20px;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    
    .midium-banner .content h3 span {
        color: #F7941D;
        font-weight: 700;
    }
    
    .midium-banner .content a {
        background: #F7941D;
        color: #fff;
        padding: 10px 20px;
        border-radius: 3px;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .midium-banner .content a:hover {
        background: #fff;
        color: #F7941D;
    }
    
    @media only screen and (max-width: 767px) {
        .midium-banner .single-banner {
            margin-bottom: 20px;
        }
        
        .midium-banner .content h3 {
            font-size: 18px;
        }
    }

    /* Product Filter & Pagination Bar */
    .product-filter-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        margin-top: 30px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .product-filter-options {
        display: flex;
        align-items: center;
    }
    
    .product-filter-options .filter-label {
        font-weight: 600;
        margin-right: 10px;
        color: #444;
    }
    
    .product-filter-options select {
        padding: 5px 25px 5px 10px;
        border: 1px solid #e9e9e9;
        border-radius: 4px;
        background-color: white;
        font-size: 14px;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;utf8,<svg fill='black' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
        background-repeat: no-repeat;
        background-position-x: calc(100% - 5px);
        background-position-y: 50%;
    }
    
    .product-filter-options .form-group {
        margin-right: 15px;
        margin-bottom: 0;
    }
    
    .product-filter-options .form-group:last-child {
        margin-right: 0;
    }
    
    .product-count {
        color: #666;
        font-size: 14px;
    }
    
    .product-count strong {
        color: #333;
        font-weight: 600;
    }
    
    /* Simple Filter Bar Styling */
    .product-navigation-simple {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    
    .product-navigation-simple .nav-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background-color: #F7941D;
        color: white;
        border-radius: 50%;
        margin: 0 5px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .product-navigation-simple .nav-btn:hover {
        background-color: #e07c0a;
        transform: scale(1.05);
        color: white;
    }
    
    .product-navigation-simple .nav-btn.disabled {
        background-color: #e0e0e0;
        color: #999;
        cursor: not-allowed;
    }
    
    .product-navigation-simple .page-indicator {
        padding: 0 12px;
        font-size: 14px;
        font-weight: 600;
        color: #555;
    }
    
    .product-filter-bar .product-filter-options {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }
    
    @media (max-width: 767px) {
        .product-filter-bar {
            flex-direction: column;
            padding: 15px;
        }
        
        .product-filter-options {
            margin-bottom: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .product-filter-options .form-group,
        .view-options {
            margin-bottom: 10px;
            margin-right: 10px;
        }
        
        .sort-options {
            margin-top: 10px;
            width: 100%;
            justify-content: center;
        }
        
        .product-count {
            text-align: center;
        }
    }
</style>
@endpush

@section('main-content')
@php
    function getImageUrl($path) {
    // If already absolute URL, return as-is
    if (strpos($path, 'http') === 0 || strpos($path, 'https') === 0) {
        return $path;
    }
    
    // Handle relative paths
    $cleanPath = preg_replace('/^storage\//', '', $path);
    return asset('storage/'.$cleanPath);
}

/**
 * Custom pagination renderer function
 * Use this function to render pagination in a consistent way across the site
 *
 * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
 * @return string
 */
function renderPagination($paginator) {
    if (!$paginator->hasPages()) {
        return '';
    }
    
    return '<div class="custom-pagination">
        <ul class="pagination">
            ' . ($paginator->onFirstPage() ? 
            '<li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>' : 
            '<li class="page-item"><a class="page-link" href="' . $paginator->previousPageUrl() . '">&laquo; Previous</a></li>') . '
            
            ' . ($paginator->hasMorePages() ? 
            '<li class="page-item"><a class="page-link" href="' . $paginator->nextPageUrl() . '">Next &raquo;</a></li>' : 
            '<li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>') . '
        </ul>
    </div>';
}

// Define hotProducts - fixing the undefined variable error
$hotProducts = \App\Models\Product::where('status', 'active')
    ->where('condition', 'hot')
    ->orderBy('created_at', 'desc')
    ->limit(8)
    ->get();
@endphp

<!-- Slider Area -->
@if(count($banners)>0)
    <section id="Gslider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($banners as $key=>$banner)
        <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
                @foreach($banners as $key=>$banner)
                <div class="carousel-item {{(($key==0)? 'active' : '')}}">
                    <img class="first-slide" src="{{ $banner->photo ? asset($banner->photo) : asset('backend/img/placeholder.jpg') }}" alt="{{$banner->title}}">
                    <div class="carousel-caption d-none d-md-block text-left">
                        <h1 class="wow fadeInDown">{{$banner->title}}</h1>
                        <p>{{strip_tags(html_entity_decode($banner->description))}}</p>
                       <center>
                            <a class="shopnow btn btn-lg ws-btn wow fadeInUpBig" href="{{route('product-grids')}}" role="button">Shop Now<i class="far fa-arrow-alt-circle-right"></i></a>
                       </center>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>
    </section>
@endif

<!--/ End Slider Area -->

<!-- Start Small Banner  -->
<section class="small-banner section">
    <div class="container-fluid">
        <div class="row">
            @php
            $category_lists=DB::table('categories')->where('status','active')->limit(3)->get();
            @endphp
            @if($category_lists)
                @foreach($category_lists as $cat)
                    @if($cat->is_parent==1)
                        <!-- Single Banner  -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-banner">
                                @if($cat->photo)
                                    <img src="{{asset($cat->photo)}}" alt="{{$cat->title}}">
                                @else
                                    <img src="{{asset('backend/img/placeholder.jpg')}}" alt="{{$cat->title}}">
                                @endif
                                <div class="content">
                                    <h3>{{$cat->title}}</h3>
                                    <a href="{{route('product-cat',$cat->slug)}}">Discover Now</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- /End Single Banner  -->
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Small Banner -->

<!-- Start Product Area -->
<div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>New Items</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="nav-main">
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                @php
                                    $categories=DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                                    // dd($categories);
                                @endphp
                                @if($categories)
                                <button class="btn" style="background:black"data-filter="*">
                                    Recently Added
                                </button>
                                    @foreach($categories as $key=>$cat)

                                    <button class="btn" style="background:none;color:black;"data-filter=".{{$cat->id}}">
                                        {{$cat->title}}
                                    </button>
                                    @endforeach
                                @endif
                            </ul>
                            <!--/ End Tab Nav -->
                        </div>
                        
                        <!-- Product Filter Bar -->
                        <div class="product-filter-bar">
                            <div class="product-filter-options">
                                <span class="filter-label">Sort By:</span>
                                <div class="form-group">
                                    <select class="sort-by-filter">
                                        <option value="newest">Newest First</option>
                                        <option value="price-low">Price: Low to High</option>
                                        <option value="price-high">Price: High to Low</option>
                                    </select>
                                </div>
                                <span class="filter-label ml-3">Show:</span>
                                <div class="form-group">
                                    <select class="items-per-page">
                                        <option value="8">8 Items</option>
                                        <option value="16">16 Items</option>
                                        <option value="24">24 Items</option>
                                    </select>
                                </div>
                            </div>
                            <div class="product-count">
                                Showing <strong>8</strong> of <strong>{{DB::table('products')->where('status', 'active')->count()}}</strong> products
                            </div>
                        </div>
                        
                        <div class="tab-content isotope-grid" id="myTabContent">            @php
        $recentlyAddedProducts = DB::table('products')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(8); // Paginate 8 products per page instead of take
    @endphp

    @foreach($recentlyAddedProducts as $key => $product)
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$product->cat_id}}">
            <div class="single-product">
                <div class="product-img">
                    <a href="{{route('product-detail', $product->slug)}}">
                        @php
                            $photos = explode(',', $product->photo);
                        @endphp
                        <img class="default-img" src="{{asset($photos[0])}}" alt="{{$product->title}}">
                        <img class="hover-img" src="{{asset($photos[0])}}" alt="{{$product->title}}">
                        @if($product->stock <= 0)
                            <span class="out-of-stock">Sold Out</span>
                        @elseif($product->condition == 'new')
                            <span class="new">New</span>
                        @elseif($product->condition == 'hot')
                            <span class="hot">Hot</span>
                        @else
                            <span class="price-dec">{{$product->discount}}% Off</span>
                        @endif
                    </a>
                    <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#quickshop-{{$product->id}}" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="{{route('add-to-wishlist', $product->slug)}}"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="{{route('add-to-cart', $product->slug)}}">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3><a href="{{route('product-detail', $product->slug)}}">{{$product->title}}</a></h3>
                    @php
                        $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                    @endphp
                    <div class="product-price">
                        <span>${{number_format($after_discount, 2)}}</span>
                        <del style="padding-left: 4%;">${{number_format($product->price, 2)}}</del>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
                    </div>
                </div>
                
                <!-- Product Pagination -->
                <div class="row">
                    <div class="col-12">
                        <div class="pagination-container">
                            {{ $recentlyAddedProducts->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
                
                <!-- Product Filter Footer Bar -->
                {{-- <div class="product-filter-bar mt-4">
                    <div class="product-filter-options">
                        <a href="{{route('product-grids')}}" class="btn btn-primary btn-sm">View All Products</a>
                    </div>
                    <div class="product-navigation-simple">
                        <div class="d-flex align-items-center">
                            @if($recentlyAddedProducts->previousPageUrl())
                                <a href="{{ $recentlyAddedProducts->previousPageUrl() }}" class="nav-btn prev-btn"><i class="fa fa-chevron-left"></i></a>
                            @else
                                <span class="nav-btn prev-btn disabled"><i class="fa fa-chevron-left"></i></span>
                            @endif
                            
                            <span class="page-indicator">{{ $recentlyAddedProducts->currentPage() }}/{{ $recentlyAddedProducts->lastPage() }}</span>
                            
                            @if($recentlyAddedProducts->nextPageUrl())
                                <a href="{{ $recentlyAddedProducts->nextPageUrl() }}" class="nav-btn next-btn"><i class="fa fa-chevron-right"></i></a>
                            @else
                                <span class="nav-btn next-btn disabled"><i class="fa fa-chevron-right"></i></span>
                            @endif
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
</div>
<!-- End Product Area -->
<!-- Start Midium Banner / Featured Products -->
<section class="midium-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Featured Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @if(isset($featured) && count($featured) > 0)
                @foreach($featured as $data)
                    <!-- Single Banner  -->
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="single-banner">
                            @php
                                $photo = explode(',',$data->photo);
                                $imgUrl = !empty($photo[0]) ? asset($photo[0]) : asset('backend/img/placeholder.jpg');
                            @endphp
                            <img src="{{$imgUrl}}" alt="{{$data->title}}">
                            <div class="content">
                                <p>{{$data->category->title ?? $data->cat_info['title'] ?? 'Featured Product'}}</p>
                                <h3>{{$data->title}} <br>@if($data->discount)Up to<span> {{$data->discount}}%</span>@endif</h3>
                                <a href="{{route('product-detail',$data->slug)}}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- /End Single Banner  -->
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No featured products available at the moment.
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- End Midium Banner / Featured Products -->

<!-- Start Most Popular -->
<div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Item</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($hotProducts as $product)
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php
                                        $photo=explode(',',$product->photo);
                                    @endphp
                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$product->title}}">
                                    <img class="hover-img" src="{{$photo[0]}}" alt="{{$product->title}}">
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a data-toggle="modal" data-target="#quickshop-{{$product->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                        <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" ><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                    </div>
                                    <div class="product-action-2">
                                        <a href="{{route('add-to-cart',$product->slug)}}">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                <div class="product-price">
                                    @php
                                        $after_discount=($product->price-($product->price*$product->discount)/100)
                                    @endphp
                                    <span>${{number_format($after_discount,2)}}</span>
                                    @if($product->discount)
                                        <span class="old">${{number_format($product->price,2)}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->

<!-- Start Shop Home List  -->
<section class="shop-home-list section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Latest Items</h1>
                        </div>
                    </div>
                </div>
                
                <!-- Latest Items Filter Bar -->
                <div class="product-filter-bar">
                    <div class="product-filter-options">
                        <span class="filter-label">Category:</span>
                        <div class="form-group">
                            <select class="category-filter">
                                <option value="">All Categories</option>
                                @foreach(DB::table('categories')->where('status','active')->where('is_parent',1)->get() as $cat)
                                    <option value="{{$cat->id}}">{{$cat->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="filter-label ml-3">Price:</span>
                        <div class="form-group">
                            <select class="price-filter">
                                <option value="">Any Price</option>
                                <option value="0-50">Under $50</option>
                                <option value="50-100">$50 to $100</option>
                                <option value="100-200">$100 to $200</option>
                                <option value="200+">$200 & Above</option>
                            </select>
                        </div>
                    </div>
                    <div class="product-count">
                        <span>Showing <strong>{{$product_lists->count()}}</strong> of <strong>{{DB::table('products')->where('status', 'active')->count()}}</strong> results</span>
                    </div>
                </div>
                <div class="row">
                    @foreach($product_lists as $product)
                        <div class="col-md-4">
                            <!-- Start Single List  -->
                            <div class="single-list">
                                <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="list-image overlay">
                                        @php
                                            $photo=explode(',',$product->photo);
                                        @endphp
                                        <img src="{{$photo[0]}}" alt="{{$product->title}}">
                                        <a href="{{route('add-to-cart',$product->slug)}}" class="buy"><i class="fa fa-shopping-bag"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 no-padding">
                                    <div class="content">
                                        <h4 class="title"><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h4>
                                        @if($product->discount)
                                            <p class="price with-discount">{{number_format($product->discount,2)}}% OFF</p>
                                        @endif
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- End Single List  -->
                        </div>
                    @endforeach

                </div>
                
                <!-- Enhanced Pagination Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="pagination-container">
                            {{ $product_lists->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
                
                <!-- Simple Product Filter Footer Bar -->
                <div class="product-filter-bar mt-4">
                    <div class="product-filter-options">
                        <a href="{{route('product-grids')}}" class="btn btn-primary btn-sm">View All Products</a>
                    </div>
                    <div class="product-navigation-simple">
                        <div class="d-flex align-items-center">
                            @if($product_lists->previousPageUrl())
                                <a href="{{ $product_lists->previousPageUrl() }}" class="nav-btn prev-btn"><i class="fa fa-chevron-left"></i></a>
                            @else
                                <span class="nav-btn prev-btn disabled"><i class="fa fa-chevron-left"></i></span>
                            @endif
                            
                            <span class="page-indicator">{{ $product_lists->currentPage() }}/{{ $product_lists->lastPage() }}</span>
                            
                            @if($product_lists->nextPageUrl())
                                <a href="{{ $product_lists->nextPageUrl() }}" class="nav-btn next-btn"><i class="fa fa-chevron-right"></i></a>
                            @else
                                <span class="nav-btn next-btn disabled"><i class="fa fa-chevron-right"></i></span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Enhanced Pagination Section -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->



<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Free shiping</h4>
                    <p>Orders over $100</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Free Return</h4>
                    <p>Within 30 days returns</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Sucure Payment</h4>
                    <p>100% secure payment</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Best Peice</h4>
                    <p>Guaranteed price</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->

@include('frontend.layouts.newsletter')

<!-- Modal -->
@if($product_lists)
    @foreach($product_lists as $key=>$product)
        <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                        <div class="product-gallery">
                                            <div class="quickview-slider-active">
                                                @php
                                                    $photo=explode(',',$product->photo);
                                                // dd($photo);
                                                @endphp
                                                @foreach($photo as $data)
                                                    <div class="single-slider">
                                                        <img src="{{ getImageUrl($data) }}" alt="{{$data}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{$product->title}}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    {{-- <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="fa fa-star"></i> --}}
                                                    @php
                                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                    @endphp
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($rate>=$i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else
                                                        <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{$rate_count}} customer review)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if($product->stock >0)
                                                <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                                @else
                                                <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <h3><small><del class="text-muted">${{number_format($product->price,2)}}</del></small>    ${{number_format($after_discount,2)}}  </h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        @if($product->size)
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Size</h5>
                                                        <select>
                                                            @php
                                                            $sizes=explode(',',$product->size);
                                                            // dd($sizes);
                                                            @endphp
                                                            @foreach($sizes as $size)
                                                                <option>{{$size}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <div class="col-lg-6 col-12">
                                                        <h5 class="title">Color</h5>
                                                        <select>
                                                            <option selected="selected">orange</option>
                                                            <option>purple</option>
                                                            <option>black</option>
                                                            <option>pink</option>
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        @endif
                                        <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
													<input type="hidden" name="slug" value="{{$product->slug}}">
                                                    <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to cart</button>
                                                <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                            </div>
                                        </form>
                                        <div class="default-social">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
    @endforeach
@endif
<!-- Modal end -->

<!-- Quick Shop Modals -->
@foreach($product_lists->items() as $product)
    <div class="modal fade" id="quickshop-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="quickshopLabel-{{$product->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickshopLabel-{{$product->id}}">Quick Shop</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Product Image -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="product-gallery">
                                <!-- Main Product Image -->
                                @php
                                    $photos = explode(',', $product->photo);
                                @endphp
                                <div class="quick-shop-main-image mb-3">
                                    <img src="{{asset($photos[0])}}" alt="{{$product->title}}" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="quick-shop-content">
                                <h2 class="mb-3">{{$product->title}}</h2>
                                
                                <div class="price-block mb-4">
                                    @php
                                        $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                    @endphp
                                    <span class="current-price">${{number_format($after_discount, 2)}}</span>
                                    @if($product->discount > 0)
                                        <span class="original-price"><s>${{number_format($product->price, 2)}}</s></span>
                                        <span class="discount-badge">{{$product->discount}}% OFF</span>
                                    @endif
                                </div>
                                
                                <div class="stock-info mb-3">
                                    @if($product->stock > 0)
                                        @if($product->stock < 5)
                                            <span class="badge badge-warning">Only {{$product->stock}} left</span>
                                        @else
                                            <span class="badge badge-success"><i class="fa fa-check-circle mr-1"></i>In Stock</span>
                                        @endif
                                    @else
                                        <span class="badge badge-danger"><i class="fa fa-times-circle mr-1"></i>Out of stock</span>
                                    @endif
                                </div>

                                <div class="product-summary mb-4">
                                    <p class="text-muted">{{strip_tags($product->summary)}}</p>
                                </div>

                                <form action="{{route('single-add-to-cart')}}" method="POST" class="product-options-form">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{$product->slug}}">
                                    
                                    @if($product->size)
                                        <div class="size-options mb-3">
                                            <label class="form-label">Size:</label>
                                            <div class="size-selection">
                                                @php
                                                    $sizes = explode(',', $product->size);
                                                @endphp
                                                <select name="size" class="form-control">
                                                    @foreach($sizes as $size)
                                                        <option value="{{$size}}">{{$size}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="quantity-options mb-4">
                                        <label class="form-label">Quantity:</label>
                                        <div class="input-group quantity-input">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-outline-secondary quantity-down">-</button>
                                            </div>
                                            <input type="text" name="quant[1]" class="qty-input form-control" value="1" min="1" max="{{$product->stock}}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary quantity-up">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action-buttons mb-3">
                                        <button type="submit" class="btn btn-primary add-to-cart-btn"><i class="fa fa-shopping-cart mr-1"></i>Add to Cart</button>
                                        <a href="{{route('add-to-wishlist', $product->slug)}}" class="btn btn-outline-secondary wishlist-btn"><i class="fa fa-heart mr-1"></i>Add to Wishlist</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach($hotProducts as $product)
    <div class="modal fade" id="quickshop-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="quickshopLabel-{{$product->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickshopLabel-{{$product->id}}">Quick Shop</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Product Image -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="product-gallery">
                                <!-- Main Product Image -->
                                @php
                                    $photos = explode(',', $product->photo);
                                @endphp
                                <div class="quick-shop-main-image mb-3">
                                    <img src="{{$photos[0]}}" alt="{{$product->title}}" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="quick-shop-content">
                                <h2 class="mb-3">{{$product->title}}</h2>
                                
                                <div class="price-block mb-4">
                                    @php
                                        $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                    @endphp
                                    <span class="current-price">${{number_format($after_discount, 2)}}</span>
                                    @if($product->discount > 0)
                                        <span class="original-price"><s>${{number_format($product->price, 2)}}</s></span>
                                        <span class="discount-badge">{{$product->discount}}% OFF</span>
                                    @endif
                                </div>
                                
                                <div class="stock-info mb-3">
                                    @if($product->stock > 0)
                                        @if($product->stock < 5)
                                            <span class="badge badge-warning">Only {{$product->stock}} left</span>
                                        @else
                                            <span class="badge badge-success"><i class="fa fa-check-circle mr-1"></i>In Stock</span>
                                        @endif
                                    @else
                                        <span class="badge badge-danger"><i class="fa fa-times-circle mr-1"></i>Out of stock</span>
                                    @endif
                                </div>

                                <div class="product-summary mb-4">
                                    <p class="text-muted">{{strip_tags($product->summary)}}</p>
                                </div>

                                <form action="{{route('single-add-to-cart')}}" method="POST" class="product-options-form">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{$product->slug}}">
                                    
                                    @if($product->size)
                                        <div class="size-options mb-3">
                                            <label class="form-label">Size:</label>
                                            <div class="size-selection">
                                                @php
                                                    $sizes = explode(',', $product->size);
                                                @endphp
                                                <select name="size" class="form-control">
                                                    @foreach($sizes as $size)
                                                        <option value="{{$size}}">{{$size}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="quantity-options mb-4">
                                        <label class="form-label">Quantity:</label>
                                        <div class="input-group quantity-input">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-outline-secondary quantity-down">-</button>
                                            </div>
                                            <input type="text" name="quant[1]" class="qty-input form-control" value="1" min="1" max="{{$product->stock}}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary quantity-up">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action-buttons mb-3">
                                        <button type="submit" class="btn btn-primary add-to-cart-btn"><i class="fa fa-shopping-cart mr-1"></i>Add to Cart</button>
                                        <a href="{{route('add-to-wishlist', $product->slug)}}" class="btn btn-outline-secondary wishlist-btn"><i class="fa fa-heart mr-1"></i>Add to Wishlist</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('styles')
    <style>

        /* Banner Sliding */
        #Gslider .carousel-inner {
        background: #000000;
        color:black;
        }

        #Gslider .carousel-inner{
        height: 550px;
        }
        #Gslider .carousel-inner img{
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        /* color: #F7941D; */
        color: #1e1e1e;
        }

        #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
        bottom: 70px;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });

        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine : 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function(){
            $(this).on('click', function(){
                for(var i=0; i<isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
        
        /**
         * Custom pagination functionality
         * This can be used to add client-side pagination to any container
         * 
         * Usage: initPagination('.your-container', '.item-selector', itemsPerPage);
         */
        function initPagination(container, itemSelector, itemsPerPage) {
            var $container = $(container);
            var $items = $container.find(itemSelector);
            var totalItems = $items.length;
            var totalPages = Math.ceil(totalItems / itemsPerPage);
            
            // If only one page or no items, don't show pagination
            if (totalPages <= 1) return;
            
            // Create pagination HTML
            var paginationHtml = '<div class="custom-pagination"><ul class="pagination">';
            
            // Previous button
            paginationHtml += '<li class="page-item disabled" data-page="prev"><span class="page-link">&laquo; Previous</span></li>';
            
            // Page numbers
            for (var i = 1; i <= totalPages; i++) {
                var activeClass = i === 1 ? 'active' : '';
                paginationHtml += '<li class="page-item ' + activeClass + '" data-page="' + i + '"><span class="page-link">' + i + '</span></li>';
            }
            
            // Next button
            paginationHtml += '<li class="page-item" data-page="next"><span class="page-link">Next &raquo;</span></li>';
            paginationHtml += '</ul></div>';
            
            // Append pagination
            $container.after(paginationHtml);
            
            // Show only first page items
            $items.hide();
            $items.slice(0, itemsPerPage).show();
            
            // Handle pagination clicks
            var $pagination = $container.next('.custom-pagination');
            var currentPage = 1;
            
            $pagination.find('.page-item').on('click', function() {
                var $this = $(this);
                var page = $this.data('page');
                
                // Handle prev/next buttons
                if (page === 'prev') {
                    if (currentPage > 1) {
                        page = currentPage - 1;
                    } else {
                        return;
                    }
                } else if (page === 'next') {
                    if (currentPage < totalPages) {
                        page = currentPage + 1;
                    } else {
                        return;
                    }
                }
                
                // Update active state
                $pagination.find('.page-item').removeClass('active');
                $pagination.find('.page-item[data-page="' + page + '"]').addClass('active');
                
                // Enable/disable prev/next buttons
                if (page === 1) {
                    $pagination.find('.page-item[data-page="prev"]').addClass('disabled');
                } else {
                    $pagination.find('.page-item[data-page="prev"]').removeClass('disabled');
                }
                
                if (page === totalPages) {
                    $pagination.find('.page-item[data-page="next"]').addClass('disabled');
                } else {
                    $pagination.find('.page-item[data-page="next"]').removeClass('disabled');
                }
                
                // Show relevant items
                $items.hide();
                $items.slice((page - 1) * itemsPerPage, page * itemsPerPage).show();
                
                // Update current page
                currentPage = page;
                
                // Scroll to container top
                $('html, body').animate({
                    scrollTop: $container.offset().top - 100
                }, 200);
            });
        }
        
        // Example usage (uncomment to use):
        // $(document).ready(function() {
        //     initPagination('.shop-home-list .row', '.col-md-4', 3);
        // });
    </script>

<!-- Quick Shop Modals -->
@foreach($product_lists->items() as $product)
    <div class="modal fade" id="quickshop-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="quickshopLabel-{{$product->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickshopLabel-{{$product->id}}">Quick Shop</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Product Image -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="product-gallery">
                                <!-- Main Product Image -->
                                @php
                                    $photos = explode(',', $product->photo);
                                @endphp
                                <div class="quick-shop-main-image mb-3">
                                    <img src="{{asset($photos[0])}}" alt="{{$product->title}}" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="quick-shop-content">
                                <h2 class="mb-3">{{$product->title}}</h2>
                                
                                <div class="price-block mb-4">
                                    @php
                                        $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                    @endphp
                                    <span class="current-price">${{number_format($after_discount, 2)}}</span>
                                    @if($product->discount > 0)
                                        <span class="original-price"><s>${{number_format($product->price, 2)}}</s></span>
                                        <span class="discount-badge">{{$product->discount}}% OFF</span>
                                    @endif
                                </div>
                                
                                <div class="stock-info mb-3">
                                    @if($product->stock > 0)
                                        @if($product->stock < 5)
                                            <span class="badge badge-warning">Only {{$product->stock}} left</span>
                                        @else
                                            <span class="badge badge-success"><i class="fa fa-check-circle mr-1"></i>In Stock</span>
                                        @endif
                                    @else
                                        <span class="badge badge-danger"><i class="fa fa-times-circle mr-1"></i>Out of stock</span>
                                    @endif
                                </div>

                                <div class="product-summary mb-4">
                                    <p class="text-muted">{{strip_tags($product->summary)}}</p>
                                </div>

                                <form action="{{route('single-add-to-cart')}}" method="POST" class="product-options-form">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{$product->slug}}">
                                    
                                    @if($product->size)
                                        <div class="size-options mb-3">
                                            <label class="form-label">Size:</label>
                                            <div class="size-selection">
                                                @php
                                                    $sizes = explode(',', $product->size);
                                                @endphp
                                                <select name="size" class="form-control">
                                                    @foreach($sizes as $size)
                                                        <option value="{{$size}}">{{$size}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="quantity-options mb-4">
                                        <label class="form-label">Quantity:</label>
                                        <div class="input-group quantity-input">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-outline-secondary quantity-down">-</button>
                                            </div>
                                            <input type="text" name="quant[1]" class="qty-input form-control" value="1" min="1" max="{{$product->stock}}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary quantity-up">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action-buttons mb-3">
                                        <button type="submit" class="btn btn-primary add-to-cart-btn"><i class="fa fa-shopping-cart mr-1"></i>Add to Cart</button>
                                        <a href="{{route('add-to-wishlist', $product->slug)}}" class="btn btn-outline-secondary wishlist-btn"><i class="fa fa-heart mr-1"></i>Add to Wishlist</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach($hotProducts as $product)
    <div class="modal fade" id="quickshop-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="quickshopLabel-{{$product->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickshopLabel-{{$product->id}}">Quick Shop</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Product Image -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="product-gallery">
                                <!-- Main Product Image -->
                                @php
                                    $photos = explode(',', $product->photo);
                                @endphp
                                <div class="quick-shop-main-image mb-3">
                                    <img src="{{$photos[0]}}" alt="{{$product->title}}" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="quick-shop-content">
                                <h2 class="mb-3">{{$product->title}}</h2>
                                
                                <div class="price-block mb-4">
                                    @php
                                        $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                    @endphp
                                    <span class="current-price">${{number_format($after_discount, 2)}}</span>
                                    @if($product->discount > 0)
                                        <span class="original-price"><s>${{number_format($product->price, 2)}}</s></span>
                                        <span class="discount-badge">{{$product->discount}}% OFF</span>
                                    @endif
                                </div>
                                
                                <div class="stock-info mb-3">
                                    @if($product->stock > 0)
                                        @if($product->stock < 5)
                                            <span class="badge badge-warning">Only {{$product->stock}} left</span>
                                        @else
                                            <span class="badge badge-success"><i class="fa fa-check-circle mr-1"></i>In Stock</span>
                                        @endif
                                    @else
                                        <span class="badge badge-danger"><i class="fa fa-times-circle mr-1"></i>Out of stock</span>
                                    @endif
                                </div>

                                <div class="product-summary mb-4">
                                    <p class="text-muted">{{strip_tags($product->summary)}}</p>
                                </div>

                                <form action="{{route('single-add-to-cart')}}" method="POST" class="product-options-form">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{$product->slug}}">
                                    
                                    @if($product->size)
                                        <div class="size-options mb-3">
                                            <label class="form-label">Size:</label>
                                            <div class="size-selection">
                                                @php
                                                    $sizes = explode(',', $product->size);
                                                @endphp
                                                <select name="size" class="form-control">
                                                    @foreach($sizes as $size)
                                                        <option value="{{$size}}">{{$size}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="quantity-options mb-4">
                                        <label class="form-label">Quantity:</label>
                                        <div class="input-group quantity-input">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-outline-secondary quantity-down">-</button>
                                            </div>
                                            <input type="text" name="quant[1]" class="qty-input form-control" value="1" min="1" max="{{$product->stock}}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary quantity-up">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action-buttons mb-3">
                                        <button type="submit" class="btn btn-primary add-to-cart-btn"><i class="fa fa-shopping-cart mr-1"></i>Add to Cart</button>
                                        <a href="{{route('add-to-wishlist', $product->slug)}}" class="btn btn-outline-secondary wishlist-btn"><i class="fa fa-heart mr-1"></i>Add to Wishlist</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endpush

@section('scripts')
<script>
    $(document).ready(function() {
        // Quantity buttons functionality
        $('.btn-number').click(function(e) {
            e.preventDefault();
            
            const type = $(this).attr('data-type');
            const input = $(this).closest('.input-group').find('input');
            const currentVal = parseInt(input.val());
            const min = parseInt(input.attr('data-min'));
            const max = parseInt(input.attr('data-max'));
            
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > min) {
                        input.val(currentVal - 1);
                    }
                    if (parseInt(input.val()) == min) {
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    if (currentVal < max) {
                        input.val(currentVal + 1);
                    }
                    if (parseInt(input.val()) > min) {
                        $(this).closest('.input-group').find('.btn-number[data-type="minus"]').attr('disabled', false);
                    }
                }
            } else {
                input.val(0);
            }
        });
        
        // Prevent negative numbers in quantity input
        $('.input-number').on('keydown', function(e) {
            if (e.which == 38) { // Up arrow
                e.preventDefault();
                const oldValue = parseInt($(this).val());
                const max = parseInt($(this).attr('data-max'));
                if (oldValue < max) {
                    $(this).val(oldValue + 1);
                }
            } else if (e.which == 40) { // Down arrow
                e.preventDefault();
                const oldValue = parseInt($(this).val());
                const min = parseInt($(this).attr('data-min'));
                if (oldValue > min) {
                    $(this).val(oldValue - 1);
                }
            }
        });
    });
</script>

<script>
         /**
         * Product filter functionality
         */
        $(document).ready(function() {
            // Sort by filter
            $('.sort-by-filter').on('change', function() {
                var sortValue = $(this).val();
                var currentUrl = new URL(window.location.href);
                
                // Update or add sort parameter
                currentUrl.searchParams.set('sort', sortValue);
                
                // Reset to page 1 when sorting changes
                currentUrl.searchParams.set('page', 1);
                
                // Redirect with new parameters
                window.location.href = currentUrl.toString();
            });
            
            // Items per page filter
            $('.items-per-page').on('change', function() {
                var perPage = $(this).val();
                var currentUrl = new URL(window.location.href);
                
                // Update or add perPage parameter
                currentUrl.searchParams.set('perPage', perPage);
                
                // Reset to page 1 when items per page changes
                currentUrl.searchParams.set('page', 1);
                
                // Redirect with new parameters
                window.location.href = currentUrl.toString();
            });
            
            // Category filter
            $('.category-filter').on('change', function() {
                var category = $(this).val();
                var currentUrl = new URL(window.location.href);
                
                // Update or add category parameter
                if (category) {
                    currentUrl.searchParams.set('category', category);
                } else {
                    currentUrl.searchParams.delete('category');
                }
                
                // Reset to page 1 when category changes
                currentUrl.searchParams.set('page', 1);
                
                // Redirect with new parameters
                window.location.href = currentUrl.toString();
            });
            
            // Price range filter
            $('.price-filter').on('change', function() {
                var priceRange = $(this).val();
                var currentUrl = new URL(window.location.href);
                
                // Update or add price parameter
                if (priceRange) {
                    currentUrl.searchParams.set('price', priceRange);
                } else {
                    currentUrl.searchParams.delete('price');
                }
                
                // Reset to page 1 when price changes
                currentUrl.searchParams.set('page', 1);
                
                // Redirect with new parameters
                window.location.href = currentUrl.toString();
            });
            
            // Set selected values based on URL parameters
            var url = new URL(window.location.href);
            
            if (url.searchParams.get('sort')) {
                $('.sort-by-filter').val(url.searchParams.get('sort'));
            }
            
            if (url.searchParams.get('perPage')) {
                $('.items-per-page').val(url.searchParams.get('perPage'));
            }
            
            if (url.searchParams.get('category')) {
                $('.category-filter').val(url.searchParams.get('category'));
            }
            
            if (url.searchParams.get('price')) {
                $('.price-filter').val(url.searchParams.get('price'));
            }
        });
    </script>
@endsection