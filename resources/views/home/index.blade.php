@component('layouts.master')

    @slot('title')
        {{ config('app.name') }}
    @endslot

    @slot('headerBlock')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css" rel="stylesheet" type="text/css" />
    @endslot

    <div class="row" style="margin-top: 10px;">
        <!-- Sidebar Starts -->
        <div class="col-md-3">
            <!-- Categories Links Starts -->
            <h3 class="side-heading hidden-xs">Menu</h3>
            <ul class="list-group categories hidden-xs">
                @each('partials.category', $categories['tree'], 'category')
            </ul>
            <!-- Categories Links Ends -->

            @include('home.special_products')
        </div>
        <!-- Sidebar Ends -->
        <!-- Primary Content Starts -->
        <div class="col-md-9">
            @include('home.slider')

            @include('ads.google_adsense_1')

            <h3 style="color: #ff884c;">Laravel powered e-Commerce online store (v2.0 - Sep 2017)</h3>

            <ul>
                <li>Full-featured shop:</li>
                <ul>
                    <li>Latest Laravel 5.4</li>
                    <li>Nested Categories</li>
                    <li>Promotion Codes</li>
                    <li>Products</li>
                    <li>Search</li>
                    <li>One-page Checkout</li>
                    <li>Flat-rate shipping</li>
                    <li>Refund</li>
                    <li>Pay Later</li>
                    <li>Cash on Delivery</li>
                    <li>Address book</li>
                    <li>Shipping tracking</li>
                    <li>Full Admin Panel</li>
                    <li>New Settings in Admin Panel <span class="label label-success">NEW</span></li>
                    <li>Quick Stats in Admin Panel Dashboard</li>
                    <li>Confirmation emails</li>
                    <li>Static pages</li>
                    <li>Social Share</li>
                    <li>...</li>
                </ul>
                <li>Payments handled by Stripe</li>
                <li>Accepts PayPal payments <span class="label label-success">NEW</span></li>
                <li>Photos uploaded and stored in Amazon S3</li>
                <li>Beautiful & responsive email templates w/ Sparkpost</li>
                <li>Responsive design (tested on iPhone, iPad, Android devices, tablets, desktops)</li>
                <li>Clean & optimal codes w/ best practices and full comments</li>
                <li>Extra: Beautiful & responsive email templates w/ Sparkpost</li>
            </ul>

            <br />
            @include('home.latest_products')
        </div>
        <!-- Primary Content Ends -->
    </div>

    @slot('bottomBlock')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>

        <script>
            (function($) {

                "use strict";

                // TOOLTIP
                $(".header-links .fa, .tool-tip").tooltip({
                    placement: "bottom"
                });
                $(".btn-wishlist, .btn-compare, .display .fa").tooltip('hide');

                $('#latest-products').slick({
                    dots: false,
                    infinite: true,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    speed: 1000,
                    prevArrow: $('.latest-products-prev'),
                    nextArrow: $('.latest-products-next'),
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                });

                // TABS
                $('.nav-tabs a').click(function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });

            })(jQuery);
        </script>
    @endslot

@endcomponent