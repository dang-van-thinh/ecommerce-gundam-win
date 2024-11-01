@extends('admin.layouts.master')
@section('title')
    404
@endsection
@section('content')
    <!-- Error 404 Template 1 - Bootstrap Brain Component -->
    <section class="py-md-5 min-vh-100 d-flex justify-content-center align-items-center py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h2 class="d-flex justify-content-center align-items-center mb-4 gap-2">
                            <span class="display-1 fw-bold">4</span>
                            <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
                            <span class="display-1 fw-bold bsb-flip-h">4</span>
                        </h2>
                        <h3 class="h2 mb-2">Oops! You're lost.</h3>
                        <p class="mb-5">The page you are looking for was not found.</p>
                        <a class="btn bsb-btn-5xl btn-dark rounded-pill fs-6 m-0 px-5" href="#!" role="button">Back to
                            Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
