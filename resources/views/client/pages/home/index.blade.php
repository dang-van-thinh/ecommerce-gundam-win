@extends('client.layouts.master')
@section('title')
    Trang chủ
@endsection
@section('content')
    <!-- Banner -->
    <section class="home-section-3 pt-0">
        @include('client.pages.home.components.banner')
    </section>

    <!-- Service -->
    <section class="section-t-space">
        @include('client.pages.home.components.service')
    </section>
    <!-- Sale info -->
    <section class="section-t-space">
        @include('client.pages.home.components.sale-info')
    </section>
    <!--san pham trending-->
    <section class="section-t-space">
        @include('client.pages.home.components.trending')
    </section>
    <!--Banner 2-->
    <section class="section-t-space">
        @include('client.pages.home.components.banner-2')
    </section>
    <!--san pham brand-->
    <section class="section-t-space">
        @include('client.pages.home.components.brand')
    </section>
    <!--top brand-->
    <section class="section-t-space">
        @include('client.pages.home.components.top-brand')
    </section>

    <!--contact-->
    <section class="section-t-space ratio3_3">
        @include('client.pages.home.components.contact')
    </section>
    <!--follow us-->
    <section class="section-b-space">
        @include('client.pages.home.components.follow-us')
    </section>
@endsection
