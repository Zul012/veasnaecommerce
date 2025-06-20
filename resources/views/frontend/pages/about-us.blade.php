@extends('frontend.layouts.master')

@section('title','Ecommerce Laravel || About Us')

@section('styles')
<style>
    .about-img img {
        width: 100%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
        object-fit: cover;
        height: 100%;
        max-height: 400px;
    }
    
    .about-img {
        padding: 10px;
        background-color: #fff;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .about-content h3 {
        font-size: 32px;
        margin-bottom: 20px;
    }
    
    .about-content h3 span {
        color: #F7941D;
    }
    
    .about-content p {
        margin-bottom: 30px;
        line-height: 1.8;
    }
</style>
@endsection

@section('main-content')

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active">About Us</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- About Us -->
	<section class="about-us section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 col-12">
						<div class="about-content">
							@php
								$settings=DB::table('settings')->get();
							@endphp
							<h3>Welcome To <span>Veasna Eonlineshoping</span></h3>
							<p>@foreach($settings as $data) {!! strip_tags($data->description) !!} @endforeach</p>
							<div class="button">
								<a href="{{route('contact')}}" class="btn primary">Contact Us</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="about-img">
							<img src="https://assets.sandsresortsmacao.cn/content/venetianmacao/press-release/2024-1-10-lv-mens-ss24-pop-up/photo-1.jpg" alt="About Us Image" class="img-fluid rounded">
						</div>
					</div>
				</div>
			</div>
	</section>
	<!-- End About Us -->


	<!-- Start Shop Services Area -->
	<section class="shop-services section">
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
@endsection
