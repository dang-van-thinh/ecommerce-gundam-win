@extends('client.layouts.master')
@section('title')
    404
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => '404',
        'parent' => [
            'route' => '',
            'name' => 'Home',
        ],
    ]);
    <section class="section-b-space pt-0">
        <div class="custom-container error-img container">
            <div class="row g-4">
                <div class="col-12 px-0"> <a href="#"><img class="img-fluid"
                            src="/template/client/assets/images/other-img/404.png" alt=""></a></div>
                <div class="col-12">
                    <h2>Page Not Found </h2>
                    <p>The page you are looking for doesn't exist or an other error occurred. Go back, or head over to
                        choose a new direction. </p><a class="btn btn_black rounded" href="index.html">Back Home Page
                        <svg>
                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                        </svg></a>
                </div>
            </div>
        </div>
    </section>
@endsection
