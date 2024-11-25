@extends('admin.layouts.master')
@section('title')
    Trang này để thử cho ae nhé :)))
@endsection
@section('content')
    <div>
        vào được rồi nè ! AE đỉnh quá :)))
    </div>
@endsection
@push('admin-scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("hello");
            window.Echo.channel("channel-test")
                .listen("TestEvent", function(message) {
                    console.log(message)
                })
        })
    </script>
@endpush
