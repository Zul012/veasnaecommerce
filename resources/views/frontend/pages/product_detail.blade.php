@extends('frontend.layouts.master')

@section('meta')
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
	<meta name="description" content="{{strip_tags($product_detail->summary)}}">
	<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
	<meta property="og:type" content="article">
	<meta property="og:title" content="{{$product_detail->title}}">
	<meta property="og:image" content="{{$product_detail->photo}}">
	<meta property="og:description" content="{{strip_tags($product_detail->description)}}">
@endsection
@section('title','Ecommerce Laravel || PRODUCT DETAIL')
@section('main-content')

		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="">Shop Details</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
				
		<!-- Shop Single -->
		<section class="shop single section">
					<div class="container">
						<div class="row"> 
							<div class="col-12">
								<div class="row">
									<div class="col-lg-6 col-12">
										<!-- Product Slider -->
										<div class="product-gallery">
											<!-- Main Product Image -->
											<div class="main-product-image mb-4">
												@php 
													$photo=explode(',',$product_detail->photo);
												@endphp
												<img id="main-product-img" src="{{$photo[0]}}" alt="{{$product_detail->title}}" class="img-fluid">
											</div>
											<!-- Thumbnail Gallery -->
											<div class="product-thumbnail-gallery">
												<div class="row">
													@foreach($photo as $key => $data)
														<div class="col-3 mb-2">
															<img src="{{$data}}" alt="Thumbnail" 
																class="img-thumbnail thumbnail-image {{$key == 0 ? 'active-thumbnail' : ''}}" 
																data-img="{{$data}}" 
																onclick="changeMainImage(this)">
														</div>
													@endforeach
												</div>
											</div>
											<!-- End Images slider -->
										</div>
										<!-- End Product slider -->
									</div>
									<div class="col-lg-6 col-12">
										<div class="product-des">
											<!-- Description -->
											<div class="short">
												<h2 class="product-title mb-3">{{$product_detail->title}}</h2>
												
												<div class="rating-main d-flex align-items-center mb-3">
													<div class="star-rating-display mr-2">
														@php
															$rate=ceil($product_detail->getReview->avg('rate'))
														@endphp
														@for($i=1; $i<=5; $i++)
															@if($rate>=$i)
																<i class="fa fa-star text-warning"></i>
															@else 
																<i class="fa fa-star-o"></i>
															@endif
														@endfor
													</div>
													<a href="#reviews" class="total-review text-muted">({{$product_detail['getReview']->count()}} Reviews)</a>
                                                </div>
                                                
                                                @php 
                                                    $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
                                                @endphp
												<div class="price-block mb-4">
													<span class="current-price">${{number_format($after_discount,2)}}</span>
													@if($product_detail->discount > 0)
														<span class="original-price"><s>${{number_format($product_detail->price,2)}}</s></span>
														<span class="discount-badge">{{$product_detail->discount}}% OFF</span>
													@endif
												</div>
												
												<div class="product-summary mb-4">
													<h5 class="mb-2">Quick Overview</h5>
													<p class="description">{{strip_tags($product_detail->summary)}}</p>
												</div>
											</div>
											<!--/ End Description -->
											<!-- Color -->
											{{-- <div class="color">
												<h4>Available Options <span>Color</span></h4>
												<ul>
													<li><a href="#" class="one"><i class="ti-check"></i></a></li>
													<li><a href="#" class="two"><i class="ti-check"></i></a></li>
													<li><a href="#" class="three"><i class="ti-check"></i></a></li>
													<li><a href="#" class="four"><i class="ti-check"></i></a></li>
												</ul>
											</div> --}}
											<!--/ End Color -->
											<!-- Size -->
											<form action="{{route('single-add-to-cart')}}" method="POST" class="product-options-form">
												@csrf
												
												@if($product_detail->size)
													<div class="size-selector mb-4">
														<h5 class="option-title">Select Size</h5>
														<div class="size-options">
															@php 
																$sizes=explode(',',$product_detail->size);
															@endphp
															<select name="size" class="form-control" required>
																<option value="">-- Choose Size --</option>
																@foreach($sizes as $size)
																	<option value="{{$size}}">{{$size}}</option>
																@endforeach
															</select>
														</div>
													</div>
												@endif
												<!--/ End Size -->
												
												<!-- Product Buy -->
												<div class="product-buy">
													<div class="quantity-selector mb-4">
														<h5 class="option-title">Quantity</h5>
														<!-- Input Order -->
														<div class="input-group">
															<div class="button minus">
																<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
																	<i class="ti-minus"></i>
																</button>
															</div>
															<input type="hidden" name="slug" value="{{$product_detail->slug}}">
															<input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1" id="quantity">
															<div class="button plus">
																<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
																	<i class="ti-plus"></i>
																</button>
															</div>
														</div>
													</div>
													
													<div class="button-group mt-4 mb-4">
														<button type="submit" class="btn btn-primary btn-lg" {{ $product_detail->stock <= 0 ? 'disabled' : '' }}>
															<i class="fa fa-shopping-cart mr-2"></i>Add to cart
														</button>
														<a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="btn btn-outline-secondary btn-lg ml-2">
															<i class="ti-heart"></i> Add to Wishlist
														</a>
													</div>
												</div>
											</form>

											<div class="product-meta mt-4">
												<div class="meta-item">
													<span class="label">Category:</span>
													<a href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a>
												</div>
												@if($product_detail->sub_cat_info)
													<div class="meta-item">
														<span class="label">Sub Category:</span>
														<a href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a>
													</div>
												@endif
												<div class="availability-block mb-3"> 
													<span class="text-muted mr-2">Availability:</span>
													@if($product_detail->stock > 0)
														@if($product_detail->stock < 5)
															<span class="badge badge-warning">Only {{$product_detail->stock}} left</span>
														@else
															<span class="badge badge-success"><i class="fa fa-check-circle mr-1"></i>In Stock</span>
														@endif
													@else
														<span class="badge badge-danger"><i class="fa fa-times-circle mr-1"></i>Out of stock</span>
													@endif
												</div>
												
												<div class="social-share mt-4">
													<h5>Share This Product:</h5>
													<ul class="social-icons mt-2">
														<li>
															<a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(route('product-detail',$product_detail->slug))}}" 
																target="_blank" class="facebook">
																<i class="fa fa-facebook"></i>
															</a>
														</li>
														<li>
															<a href="https://twitter.com/intent/tweet?url={{urlencode(route('product-detail',$product_detail->slug))}}&text={{urlencode($product_detail->title)}}" 
																target="_blank" class="twitter">
																<i class="fa fa-twitter"></i>
															</a>
														</li>
														<li>
															<a href="https://pinterest.com/pin/create/button/?url={{urlencode(route('product-detail',$product_detail->slug))}}&media={{urlencode($photo[0])}}&description={{urlencode($product_detail->title)}}" 
																target="_blank" class="pinterest">
																<i class="fa fa-pinterest"></i>
															</a>
														</li>
														<li>
															<a href="mailto:?subject={{urlencode($product_detail->title)}}&body=Check out this product: {{urlencode(route('product-detail',$product_detail->slug))}}" 
																class="instagram">
																<i class="fa fa-envelope"></i>
															</a>
														</li>
													</ul>
												</div>
											</div>
											<!--/ End Product Buy -->
											<!-- Visit 'codeastro' for more projects -->
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="product-info">
											<div class="nav-main">
												<!-- Tab Nav -->
												<ul class="nav nav-tabs product-tabs" id="productTab" role="tablist">
													<li class="nav-item">
														<a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
															<i class="fa fa-file-text-o mr-2"></i>Description
														</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">
															<i class="fa fa-comments-o mr-2"></i>Reviews <span class="count">({{$product_detail['getReview']->count()}})</span>
														</a>
													</li>
												</ul>
												<!--/ End Tab Nav -->
											</div>
											<div class="tab-content product-tab-content" id="productTabContent">
												<!-- Description Tab -->
												<div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
													<div class="tab-single">
														<div class="row">
															<div class="col-12">
																<div class="product-description">
																	{{strip_tags($product_detail->description)}}
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--/ End Description Tab -->
												<!-- Reviews Tab -->
												<div class="tab-pane fade" id="reviews" role="tabpanel">
													<div class="tab-single review-panel">
														<div class="row">
															<div class="col-12">
																
																<!-- Review -->
																<div class="comment-review">
																	<div class="review-form-wrapper">
																		<div class="review-form-header">
																			<h4 class="mb-3">Share Your Review</h4>
																			<p class="text-muted mb-4">Your feedback helps other shoppers make better decisions</p>
																		</div>
																		
																		@auth
																		<form class="review-form" method="post" action="{{route('review.store',$product_detail->slug)}}">
																			@csrf
																			@if(request()->has('page'))
																				<input type="hidden" name="page" value="{{request('page')}}">
																			@endif
																			<div class="row">
																				<div class="col-lg-12 col-12 mb-4">
																					<label class="form-label">Rating <span class="text-danger">*</span></label>
																					<div class="rating-selection">
																						<div class="star-rating">
																							<div class="star-rating__wrap">
																								<input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5">
																								<label class="star-rating__ico fa fa-star-o" for="star-rating-5" title="5 out of 5 stars"></label>
																								<input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4">
																								<label class="star-rating__ico fa fa-star-o" for="star-rating-4" title="4 out of 5 stars"></label>
																								<input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3">
																								<label class="star-rating__ico fa fa-star-o" for="star-rating-3" title="3 out of 5 stars"></label>
																								<input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2">
																								<label class="star-rating__ico fa fa-star-o" for="star-rating-2" title="2 out of 5 stars"></label>
																								<input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1">
																								<label class="star-rating__ico fa fa-star-o" for="star-rating-1" title="1 out of 5 stars"></label>
																							</div>
																						</div>
																						@error('rate')
																							<div class="text-danger mt-2">{{$message}}</div>
																						@enderror
																					</div>
																				</div>
																				
																				<div class="col-lg-12 col-12 mb-4">
																					<div class="form-group">
																						<label class="form-label">Your Review <span class="text-danger">*</span></label>
																						<textarea name="review" rows="5" class="form-control" placeholder="Share your experience with this product"></textarea>
																					</div>
																				</div>
																				
																				<div class="col-lg-12 col-12">
																					<div class="form-group">
																						<button type="submit" class="btn btn-primary">Submit Review</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		@else 
																		<div class="login-to-review text-center py-4 border rounded">
																			<i class="fa fa-user-circle-o fa-3x mb-3 text-muted"></i>
																			<h5 class="mb-3">Login to Write a Review</h5>
																			<p class="mb-4">Share your thoughts with other customers</p>
																			<a href="{{route('login.form')}}" class="btn btn-primary">Login Now</a>
																			<p class="mt-3 small text-muted">
																				Don't have an account? <a href="{{route('register.form')}}">Register</a>
																			</p>
																		</div>
																		@endauth
																	</div>
																</div>
															
																<div class="ratting-main">
																	<div class="avg-ratting">
																		{{-- @php 
																			$rate=0;
																			foreach($product_detail->rate as $key=>$rate){
																				$rate +=$rate
																			}
																		@endphp --}}
																		@php
																			$avg_rating = 0;
																			$review_count = $product_detail->getReview->count();
																			if($review_count > 0) {
																				$avg_rating = ceil($product_detail->getReview->avg('rate'));
																			}
																		@endphp
																		<h4>{{$avg_rating}} <span>(Overall)</span></h4>
																		<span>Based on {{$review_count}} Comments</span>
																	</div>
																	
																	@if(count($reviews) > 0)
																		@foreach($reviews as $data)
																		<!-- Single Rating -->
																		<div class="single-rating">
																			<div class="rating-author">
																				@if($data->user_info['photo'])
																				<img src="{{$data->user_info['photo']}}" alt="{{$data->user_info['photo']}}">
																				@else 
																				<img src="{{asset('backend/img/avatar.png')}}" alt="Profile.jpg">
																				@endif
																			</div>
																			<div class="rating-des">
																				<h6>{{$data->user_info['name']}}</h6>
																				<div class="ratings">
																					<ul class="rating">
																						@for($i=1; $i<=5; $i++)
																							@if($data->rate>=$i)
																								<li><i class="fa fa-star"></i></li>
																							@else 
																								<li><i class="fa fa-star-o"></i></li>
																							@endif
																						@endfor
																					</ul>
																					<div class="rate-count">(<span>{{$data->rate}}</span>)</div>
																				</div>
																				<p>{{$data->review}}</p>
																			</div>
																		</div>
																		<!--/ End Single Rating -->
																		@endforeach
																		
																		<!-- Pagination -->
																		<div class="reviews-pagination mt-4">
																			{{ $reviews->links('vendor.pagination.bootstrap-4') }}
																		</div>
																	@else
																		<div class="text-center py-4">
																			<p>No reviews yet. Be the first to review this product!</p>
																		</div>
																	@endif
																</div>
																
																<!--/ End Review -->
																
															</div>
														</div>
													</div>
												</div>
												<!--/ End Reviews Tab -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		</section>
		<!--/ End Shop Single -->
		<!-- Visit 'codeastro' for more projects -->
		<!-- Start Most Popular -->
	<div class="product-area most-popular related-product section">
        <div class="container">
            <div class="row">
				<div class="col-12">
					<div class="section-title">
						<h2>Related Products</h2>
					</div>
				</div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach($product_detail->rel_prods as $data)
                            @if($data->id !== $product_detail->id)
                                <!-- Start Single Product -->
                                <div class="single-product product-card">
                                    <div class="product-img">
										<a href="{{route('product-detail',$data->slug)}}">
											@php 
												$photo=explode(',',$data->photo);
                                                $after_discount=($data->price-(($data->discount*$data->price)/100));
											@endphp
                                            <img class="default-img" src="{{$photo[0]}}" alt="{{$data->title}}">
                                            <img class="hover-img" src="{{$photo[0]}}" alt="{{$data->title}}">
                                            @if($data->discount)
                                                <span class="price-dec">{{$data->discount}}% Off</span>
                                            @endif
                                            @if($data->stock <= 0)
                                                <span class="out-of-stock">Out of Stock</span>
                                            @endif
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#quickShop" data-product-id="{{$data->id}}" 
                                                   data-title="{{$data->title}}" 
                                                   data-price="{{number_format($after_discount,2)}}" 
                                                   data-original-price="{{number_format($data->price,2)}}" 
                                                   data-discount="{{$data->discount}}" 
                                                   data-image="{{$photo[0]}}"
                                                   data-description="{{strip_tags($data->summary)}}" 
                                                   data-stock="{{$data->stock}}"
                                                   data-slug="{{$data->slug}}"
                                                   class="quick-view-btn" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick View</span></a>
                                                <a title="Wishlist" href="{{route('add-to-wishlist',$data->slug)}}"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a title="Add to cart" href="{{route('add-to-cart',$data->slug)}}">Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="{{route('product-detail',$data->slug)}}">{{$data->title}}</a></h3>
                                        <div class="product-price">
                                            @if($data->discount)
                                                <span class="old">${{number_format($data->price,2)}}</span>
                                            @endif
                                            <span>${{number_format($after_discount,2)}}</span>
                                        </div>
                                        <div class="star-rating-mini">
                                            @php
                                                $rate = 0;
                                                if($data->getReview->count() > 0){
                                                    $rate = ceil($data->getReview->avg('rate'));
                                                }
                                            @endphp
                                            @for($i=1; $i<=5; $i++)
                                                @if($rate >= $i)
                                                    <i class="fa fa-star"></i>
                                                @else
                                                    <i class="fa fa-star-o"></i>
                                                @endif
                                            @endfor
                                            <span class="rating-count">({{$data->getReview->count()}})</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Product -->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- End Most Popular Area -->
	

<!-- Quick Shop Modal -->
<div class="modal fade" id="quickShop" tabindex="-1" role="dialog" aria-labelledby="quickShopLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickShopLabel">Quick Shop</h5>
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
                            <div class="quick-shop-main-image mb-3">
                                <img id="quick-shop-image" src="" alt="Product Image" class="img-fluid">
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="quick-shop-content">
                            <h2 id="quick-shop-title" class="mb-3"></h2>
                            
                            <div class="price-block mb-4">
                                <span id="quick-shop-price" class="current-price"></span>
                                <span id="quick-shop-original-price" class="original-price"></span>
                                <span id="quick-shop-discount" class="discount-badge"></span>
                            </div>
                            
                            <div class="stock-info mb-3">
                                <span id="quick-shop-stock-status"></span>
                            </div>

                            <div class="product-summary mb-4">
                                <p id="quick-shop-description" class="text-muted"></p>
                            </div>

                            <form action="{{route('single-add-to-cart')}}" method="POST" class="product-options-form">
                                @csrf
                                <input type="hidden" name="slug" id="quick-shop-slug" value="">
                                <div class="quantity-selector mb-4">
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quick-shop-quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quick-shop-quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="button-group">
                                    <button type="submit" id="quick-shop-add-to-cart" class="btn btn-primary">
                                        <i class="fa fa-shopping-cart mr-2"></i>Add to cart
                                    </button>
                                    <a id="quick-shop-add-to-wishlist" href="#" class="btn btn-outline-secondary ml-2">
                                        <i class="ti-heart"></i> Add to Wishlist
                                    </a>
                                </div>
                            </form>
                            
                            <div class="product-meta mt-4">
                                <div class="social-share">
                                    <h5>Share:</h5>
                                    <ul class="social-icons mt-2">
                                        <li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" class="instagram"><i class="fa fa-instagram"></i></a></li>
                                        <li><a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="quick-shop-view-details" href="#" class="btn btn-link">View Full Details</a>
            </div>
        </div>
    </div>
</div>
<!-- End Quick Shop Modal -->

@endsection
@push('styles')
	<style>
		/* Rating */
		.rating_box {
		display: inline-flex;
		}

		.star-rating {
		font-size: 0;
		padding-left: 10px;
		padding-right: 10px;
		}

		.star-rating__wrap {
		display: inline-block;
		font-size: 1rem;
		}

		.star-rating__wrap:after {
		content: "";
		display: table;
		clear: both;
		}

		.star-rating__ico {
		float: right;
		padding-left: 2px;
		cursor: pointer;
		color: #F7941D;
		font-size: 16px;
		margin-top: 5px;
		}

		.star-rating__ico:last-child {
		padding-left: 0;
		}

		.star-rating__input {
		display: none;
		}

		.star-rating__ico:hover:before,
		.star-rating__ico:hover ~ .star-rating__ico:before,
		.star-rating__input:checked ~ .star-rating__ico:before {
		content: "\F005";
		}

        /* Product detail page styling */
        .main-product-image {
            border: 1px solid #eee;
            padding: 5px;
            border-radius: 5px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .main-product-image img {
            max-height: 380px;
            object-fit: contain;
        }
        
        .thumbnail-image {
            cursor: pointer;
            height: 80px;
            object-fit: cover;
            transition: all 0.3s;
        }
        
        .thumbnail-image.active-thumbnail {
            border: 2px solid #F7941D;
        }
        
        .price-block .current-price {
            font-size: 24px;
            font-weight: 600;
            color: #F7941D;
        }
        
        .price-block .original-price {
            font-size: 18px;
            color: #999;
            margin-left: 10px;
        }
        
        .price-block .discount-badge {
            background: #F7941D;
            color: #fff;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 14px;
            margin-left: 10px;
        }
        
        .product-title {
            font-size: 28px;
            font-weight: 600;
        }
        
        .star-rating-display i {
            color: #F7941D;
        }
        
        .product-tabs {
            border-bottom: 2px solid #eee;
        }
        
        .product-tabs .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            color: #666;
            font-weight: 600;
        }
        
        .product-tabs .nav-link.active {
            border-color: #F7941D;
            color: #F7941D;
        }
        
        .product-tab-content {
            padding: 30px 0;
        }
        
        .review-form-wrapper {
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .single-rating {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .rating-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }
        
        .social-icons {
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
        }
        
        .social-icons li {
            margin-right: 10px;
        }
        
        .social-icons li a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: all 0.3s;
        }
        
        .social-icons .facebook {
            background: #3b5998;
        }
        
        .social-icons .twitter {
            background: #1da1f2;
        }
        
        .social-icons .instagram {
            background: #c13584;
        }
        
        .social-icons .pinterest {
            background: #bd081c;
        }
        
        /* Quick Shop Modal */
        #quickShop .modal-content {
            border-radius: 8px;
        }
        
        #quickShop .modal-header {
            border-bottom: 1px solid #eee;
        }
        
        #quickShop .modal-title {
            font-weight: 600;
            color: #222;
        }
        
        #quickShop .quick-shop-main-image {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee;
            border-radius: 8px;
        }
        
        #quickShop .quick-shop-main-image img {
            max-height: 280px;
            object-fit: contain;
        }
        
        #quickShop .stock-info .in-stock {
            color: #28a745;
        }
        
        #quickShop .stock-info .out-of-stock {
            color: #dc3545;
        }
        
        #quickShop .modal-footer {
            border-top: 1px solid #eee;
        }
        
        .product-card {
            transition: all 0.3s;
            margin: 10px 0;
        }
        
        .product-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .star-rating-mini i {
            color: #F7941D;
            font-size: 14px;
        }
        
        .star-rating-mini .rating-count {
            color: #999;
            font-size: 12px;
            margin-left: 5px;
        }
		
		/* Review pagination styling */
        .reviews-pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        
        .reviews-pagination .pagination {
            margin: 1px;
        }
        
        .reviews-pagination .page-item .page-link {
            color: #333;
            border-color: #ddd;
            padding: 8px 16px;
            line-height: 2px;
            font-size: 15px;
            margin: 2px;
            border-radius: 4px;
        }
        
        .reviews-pagination .page-item.active .page-link {
            background-color: #F7941D;
            border-color: #F7941D;
            color: #fff;
        }
        
        .reviews-pagination .page-item.disabled .page-link {
            color: #999;
        }
        
        .reviews-pagination .page-item:first-child .page-link,
        .reviews-pagination .page-item:last-child .page-link {
            padding: 8px 14px;
        }
        
        .reviews-pagination .page-item .page-link:hover {
            background-color: #f8f9fa;
            color: #F7941D;
            border-color: #ddd;
        }
	</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    // Main Image Change Function
    function changeMainImage(element) {
        // Get the clicked thumbnail image source
        const imgSrc = $(element).data('img');
        
        // Update the main product image
        $('#main-product-img').attr('src', imgSrc);
        
        // Remove active class from all thumbnails
        $('.thumbnail-image').removeClass('active-thumbnail');
        
        // Add active class to clicked thumbnail
        $(element).addClass('active-thumbnail');
    }
    
    // Initialize Product Images
    $(document).ready(function() {
        // Quick Shop Modal Handler
        $('.quick-view-btn').on('click', function(e) {
            e.preventDefault();
            
            // Get product data from data attributes
            const productId = $(this).data('product-id');
            const title = $(this).data('title');
            const price = $(this).data('price');
            const originalPrice = $(this).data('original-price');
            const discount = $(this).data('discount');
            const image = $(this).data('image');
            const description = $(this).data('description');
            const stock = $(this).data('stock');
            const slug = $(this).data('slug');
            
            // Populate modal with product data
            $('#quick-shop-title').text(title);
            $('#quick-shop-price').text('$' + price);
            $('#quick-shop-image').attr('src', image);
            $('#quick-shop-description').text(description);
            $('#quick-shop-slug').val(slug);
            $('#quick-shop-view-details').attr('href', '{{ url("product-detail") }}/' + slug);
            $('#quick-shop-add-to-wishlist').attr('href', '{{ url("add-to-wishlist") }}/' + slug);
            
            // Display original price and discount if applicable
            if (discount > 0) {
                $('#quick-shop-original-price').html('<s>$' + originalPrice + '</s>').show();
                $('#quick-shop-discount').text(discount + '% OFF').show();
            } else {
                $('#quick-shop-original-price, #quick-shop-discount').hide();
            }
            
            // Update stock status
            if (stock > 0) {
                if (stock < 5) {
                    $('#quick-shop-stock-status').html('<span class="badge badge-warning">Only ' + stock + ' left</span>');
                } else {
                    $('#quick-shop-stock-status').html('<span class="badge badge-success"><i class="fa fa-check-circle mr-1"></i>In Stock</span>');
                }
                $('#quick-shop-add-to-cart').prop('disabled', false);
            } else {
                $('#quick-shop-stock-status').html('<span class="badge badge-danger"><i class="fa fa-times-circle mr-1"></i>Out of stock</span>');
                $('#quick-shop-add-to-cart').prop('disabled', true);
            }
        });
        
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
        
        // Initialize product tab functionality
        $('#productTab a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@endpush