<style>
    .readed {
        background-color: white;
    }

    .readed:hover {
        background-color: gray;
    }

    #delete-notification:hover {
        text-decoration-line: underline;
    }

    .not-read {
        background-color: #ff004229;
    }

    .not-read:hover {
        background-color: gray;
    }

    .icon-number {
        border-radius: 50%;
        color: #fff;
        font-size: 11px;
        height: 15px;
        width: 15px;
        line-height: 15px;
        right: 0;
        top: 12px;
        position: absolute;
    }
</style>
<div class="top-left">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><img src="/template/images/logo-gundam.png"
                alt="Logo"></a>
        <a class="navbar-brand hidden" href="{{ route('dashboard') }}"><img src="/template/images/logo2.png"
                alt="Logo"></a>
        <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
    </div>
</div>
<div class="top-right">
    <div class="header-menu">
        <div class="header-left">
            <button class="search-trigger"><i class="fa fa-search"></i></button>
            <div class="form-inline">
                <form class="search-form">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                    <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                </form>
            </div>

            <div class="dropdown for-notification">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <p class="bg-danger icon-number" id="number-noti">0</p>
                </button>
                <div class="dropdown-menu" aria-labelledby="notification" id="notifications"
                    style="max-height: 30rem;overflow: scroll; max-width: 30rem">
                    <div class="justify-content-between flex px-1">
                        <p href="" class="" style="cursor: pointer" id="delete-notification">Xóa</p>
                    </div>
                    {{--                    <a class="dropdown-item media" href="#"> --}}
                    {{--                        <i class="fa fa-check"></i> --}}
                    {{--                        <p>Server #1 overloaded.</p> --}}
                    {{--                    </a> --}}
                </div>
            </div>

            {{-- <div class="dropdown for-message">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope"></i>
                    <span class="count bg-primary">4</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="message">
                    <p class="red">You have 4 Mails</p>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar" src="/template/images/avatar/1.jpg"></span>
                        <div class="message media-body">
                            <span class="name float-left">Jonathan Smith</span>
                            <span class="time float-right">Just now</span>
                            <p>Hello, this is an example msg</p>
                        </div>
                    </a>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar" src="/template/images/avatar/2.jpg"></span>
                        <div class="message media-body">
                            <span class="name float-left">Jack Sanders</span>
                            <span class="time float-right">5 minutes ago</span>
                            <p>Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                    </a>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar" src="/template/images/avatar/3.jpg"></span>
                        <div class="message media-body">
                            <span class="name float-left">Cheryl Wheeler</span>
                            <span class="time float-right">10 minutes ago</span>
                            <p>Hello, this is an example msg</p>
                        </div>
                    </a>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar" src="/template/images/avatar/4.jpg"></span>
                        <div class="message media-body">
                            <span class="name float-left">Rachel Santos</span>
                            <span class="time float-right">15 minutes ago</span>
                            <p>Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                    </a>
                </div>
            </div> --}}
        </div>

        <div class="user-area dropdown float-right">
            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <img class="user-avatar rounded-circle" src="/template/images/admin.jpg" alt="User Avatar">
            </a>

            <div class="user-menu dropdown-menu">
                <a class="nav-link" href="{{ route('home') }}"><i class="fa fa- user"></i>Trang chủ</a>

                <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" title="Đăng xuất" class="nav-link" style="margin-left: 10px;">
                        <a>Đăng xuất</a>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>


@push('admin-scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var notificationElement = document.getElementById("notifications");

            // load notifications json
            // {
            //     "title": "Xác nhận đơn hàng mới ",
            //     "message": "Đơn hàng #51J2A452IZBG05 đã được tạo ",
            //     "redirect_url": "http://127.0.0.1:8000/admin/orders/79/edit",
            //     "user_id": 1,
            //     "updated_at": "2024-11-23T19:55:03.000000Z",
            //     "created_at": "2024-11-23T19:55:03.000000Z",
            //     "id": 11
            // }

            handlenotification();
            // console.log("heloo")
            window.Echo.channel("order-to-admin")
                .listen("OrderToAdminEvent", function(data) {
                    let numberNoti = document.getElementById("number-noti");
                    numberNoti.textContent = Number(numberNoti.textContent) + 1;
                    console.log(JSON.stringify(data), data.noties);
                    let noties = data.noties;

                    let aElement = document.createElement("a");
                    let iElementCheck = document.createElement("i")
                    iElementCheck.classList.add("fa");
                    aElement.setAttribute("data-id", noties.id)
                    iElementCheck.classList.add("fa-check");
                    let pElement = document.createElement("p");
                    aElement.classList.add("dropdown-item");
                    aElement.classList.add("media");
                    aElement.classList.add("notification");

                    if (noties.redirect_url != null) {
                        aElement.setAttribute("href", noties.redirect_url)
                    } else {
                        aElement.setAttribute("href", "#")
                    }

                    if (noties.read_at == null) {
                        aElement.classList.add("not-read")
                    } else {
                        aElement.classList.add("readed")
                    }
                    pElement.innerText = noties.message

                    aElement.appendChild(iElementCheck)
                    aElement.appendChild(pElement);
                    notificationElement.appendChild(aElement);

                    // hien thị thông báo
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "timeOut": "5000",
                    };
                    toastr.info(noties.message);
                });
        })

        function handlenotification() {
            let notificationElement = document.getElementById("notifications");
            window.axios.get("/api/notification").then((response) => {
                let numberNoti = document.getElementById("number-noti");
                // console.log(response.data, notificationElement)

                let noties = response.data;
                numberNoti.textContent = noties.countNoties;

                noties.allNoties.forEach((noti, index) => {
                    // console.log(noti)
                    let aElement = document.createElement("a");
                    let iElementCheck = document.createElement("i")
                    iElementCheck.classList.add("fa");
                    iElementCheck.classList.add("fa-check");
                    aElement.setAttribute("data-id", noti.id)
                    let pElement = document.createElement("p");
                    aElement.classList.add("dropdown-item");
                    aElement.classList.add("media");
                    aElement.classList.add("notification");

                    if (noti.redirect_url != null) {
                        aElement.setAttribute("href", noti.redirect_url)
                    } else {
                        aElement.setAttribute("href", "#")
                    }

                    if (noti.read_at == null) {
                        aElement.classList.add("not-read")
                    } else {
                        aElement.classList.add("readed")
                    }
                    pElement.innerText = noti.message

                    aElement.appendChild(iElementCheck)
                    aElement.appendChild(pElement);
                    notificationElement.appendChild(aElement);
                })

            }).then(() => {
                document.querySelectorAll(".notification").forEach((element) => {
                    console.log(element.getAttribute("data-id"))
                    element.addEventListener("click", (e) => {
                        // alert("sadsa")
                        window.axios.put("/api/notification/update", {
                            id: element.getAttribute("data-id")
                        });
                    })
                })

                document.getElementById('delete-notification').addEventListener("click", (e) => {
                    window.axios.delete("/api/notification/delete").then((res) => {
                        let parent = e.target.parentNode.parentNode;
                        let notiNotRead = parent.querySelectorAll(".readed");

                        notiNotRead.forEach(el => {
                            parent.removeChild(el);
                        })
                    })
                })
            })
        }
    </script>
@endpush
