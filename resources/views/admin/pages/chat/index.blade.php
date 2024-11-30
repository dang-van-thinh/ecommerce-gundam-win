@extends('admin.layouts.master')
@section('title')
    Nhắn tin
@endsection
@push('admin-css')
    <style>
        .message {
            max-width: 90%;
            word-wrap: break-word;
            /* Đảm bảo các từ dài sẽ xuống dòng */
            overflow-wrap: break-word;
            /* Phòng tránh các từ dài không gãy xuống dòng */
        }

        .box-user {
            cursor: pointer;
            padding: 5px;
        }

        .box-user:hover {
            background-color: rgba(185, 213, 216, 0.58);
            box-shadow: 0 0 6px -2px gray;
            border-radius: 0.5rem;
        }
    </style>
@endpush
@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-4 m-0 p-0">
                <div class="card overflow-auto" style="max-height: 85vh">
                    <div class="card-body">
                        <div class="mb-2">
                            <input type="text" class="form-control fs-6" placeholder="Tìm kiếm" id="search-user-chat">
                        </div>
                        <div id="show-users">
                            {{--                            <div class="d-flex justify-content-start mb-4 flex-row box-user"> --}}
                            {{--                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" --}}
                            {{--                                     alt="avatar 1" style="width: 45px; height: 100%;"> --}}
                            {{--                                <div class="d-flex flex-column ms-2 flex-shrink-0"> --}}
                            {{--                                    <h3 class="fs-6 name-user" data-id="2">Nguyenx van a</h3> --}}
                            {{--                                    <p class="my-1" style="font-size: 12px">heloo my frined</p> --}}
                            {{--                                </div> --}}
                            {{--                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8 m-0 p-0">
                <section>
                    <div class="container">
                        <div class="row d-flex" id="room-chat">

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@push('admin-scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const adminId = "{{ Auth::id() ? Auth::id() : null }}";
            console.log(adminId)

            // hien thi het user ra
            window.axios.get("/api/chat-users", {
                params: {
                    userId: adminId
                }
            }).then((res) => {
                console.log(res.data.users);
                showUsers(res.data.users)
            }).then(() => {
                document.querySelectorAll(".box-user").forEach((element) => {
                    element.addEventListener("click", function(e) {

                        let nameUser = this.querySelector(".name-user")
                        let userId = nameUser.getAttribute("data-id");
                        let image = this.querySelector("img").getAttribute("src");
                        // console.log(image);

                        showRoomChat(userId, nameUser.textContent, adminId, image);

                        // huy channel neu da co truoc do de tranh bij gui nham
                        if (currentChannel) {
                            currentChannel.stopListening("ChatMessage");
                        }

                        currentChannel = window.Echo.private(`chat.${userId}`)
                            .listen("ChatMessage", function(data) {
                                // console.log("sadjkajs")
                                const message = data.message;
                                console.log({
                                    message
                                });
                                if (message.sender_id == adminId) {
                                    showChatSend(message.message)
                                } else {
                                    showChatReceive(message.message)
                                }
                            });

                        // gui api tin nhan di
                        const btnAdminChat = document.getElementById("admin-chat")
                        btnAdminChat.addEventListener("submit", (e) => {
                            e.preventDefault()
                            const message = document.querySelector(
                                "input[name=message]")
                            // console.log(message.value)
                            window.axios.post('/api/chat-send', {
                                message: message.value,
                                sender_id: adminId,
                                receiver_id: userId
                            });
                            // showChatSend(message.value)
                            message.value = '';
                        })
                    })
                });
            });
            //tim kiem user
            document.getElementById("search-user-chat").addEventListener("input", (e) => {
                console.log(e.target.value);
                window.axios.get("/api/chat/search-user", {
                    params: {
                        search: e.target.value,
                        userId: adminId
                    }
                }).then((res) => {
                    let users = res.data.users;
                    // console.log(res);
                    showUsers(users);
                }).then(() => {
                    document.querySelectorAll(".box-user").forEach((element) => {
                        element.addEventListener("click", function(e) {

                            let nameUser = this.querySelector(".name-user")
                            let image = this.querySelector("img").getAttribute(
                                "src");
                            let userId = nameUser.getAttribute("data-id");
                            // alert("anhr ot ".image);

                            showRoomChat(userId, nameUser.textContent, adminId,
                                image);

                            // huy channel neu da co truoc do de tranh bij gui nham
                            if (currentChannel) {
                                currentChannel.stopListening("ChatMessage");
                            }

                            currentChannel = window.Echo.private(`chat.${userId}`)
                                .listen("ChatMessage", function(data) {
                                    // console.log("sadjkajs")
                                    const message = data.message;
                                    const user = data.message.user_sender;
                                    console.log(user, message);
                                    if (message.sender_id == adminId) {
                                        showChatSend(message.message, user
                                            .image)
                                    } else {
                                        showChatReceive(message.message, user
                                            .image)
                                    }
                                });

                            // gui api tin nhan di
                            const btnAdminChat = document.getElementById(
                                "admin-chat")
                            btnAdminChat.addEventListener("submit", (e) => {
                                e.preventDefault()
                                const message = document.querySelector(
                                    "input[name=message]")
                                // console.log(message.value)
                                window.axios.post('/api/chat-send', {
                                    message: message.value,
                                    sender_id: adminId,
                                    receiver_id: userId
                                });
                                // showChatSend(message.value)
                                message.value = '';
                            })
                        })
                    });
                });
            })

            // ket noi channel
            let currentChannel = null;


        });

        function showUsers(users) {
            let showUser = document.getElementById("show-users");
            let html = '';
            users.forEach((user) => {
                let userName = user.full_name;
                let userId = user.id;
                let email = user.email;
                console.log(user.image);
                let image = "";
                if (user.image == null) {
                    image = "https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp";
                } else {
                    image = `/storage/${user.image}`
                }
                html += `
                    <div class="d-flex justify-content-start mb-3 flex-row box-user">
                        <img src="${image}"
                             alt="avatar 1" style="width: 45px; height:45px" class="rounded-circle">
                        <div class="d-flex flex-column ms-2 flex-shrink-0">
                            <h3 class="fs-6 name-user" data-id="${userId}">${userName}</h3>
                            <p class="my-1" style="font-size: 12px">${email}</p>
                        </div>
                    </div>`;
            })
            showUser.innerHTML = html;
        }

        function showMessageOfRoom(userId) {
            window.axios.get("/api/chat-messages", {
                params: {
                    userId: userId
                }
            }).then((data) => {
                const messages = data.data.messages;
                console.log(messages)
                messages.forEach((message, index) => {
                    console.log(message)
                    let img = message.user_sender.image
                    // doan nay phai nguoc laij voi ben nguoi dung
                    if (message.sender_id == userId) {
                        showChatReceive(message.message, img);
                    } else {
                        showChatSend(message.message, img)
                    }
                });

            })
        }

        function showRoomChat(userId, userName, adminId, image) {
            let roomChat = document.getElementById("room-chat");
            let html = `
                         <div class="col-12" style="height: 85vh">
                                <div class="card h-100 position-relative h-100 overflow-auto" id="chat1"
                                     style="border-radius: 15px;">
                                    <div
                                        class="card-header d-flex justify-content-between align-items-center bg-info border-bottom-0 p-3 text-white"
                                        style="border-top-left-radius: 15px; border-top-right-radius: 15px; max-height: 8%;">
                                        <div class="flex-grow-1 flex-shrink-0 overflow-hidden">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="position-relative w-50 d-flex align-items-center justify-content-start h-50">
                                                    <img src="${image}" width="40px" height="40px"
                                                         class="rounded-circle" alt="">
                                                    <div
                                                        class="d-flex h-100 flex-column justify-content-center align-items-center mx-2 pt-2">
                                                        <h5>${userName}</h5>
                                                        <input type="hidden" name="id-user" value="${userId}">
                                                        <p class="text-white-50">Online</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="max-height: 83%; height: 83%">
                                        <div  class="card-body overflow-y-scroll"  id="show-chat" style="height: 100%"></div>
                                    </div>
                                    <div class="card-body position-absolute bottom-0 border border-1"
                                         style="max-height: 10%">
                                        <form id="admin-chat">
                                            <div class="row">
                                                <div class="col-10">
                                                    <input type="text" name="message" class="form-control"
                                                           placeholder="Nhập vào đây"></input>
                                                </div>
                                                <div class="col-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        <img width="20"
                                                             height="20"
                                                             src="https://img.icons8.com/color/48/sent--v2.png"
                                                             alt="sent--v2"/>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                    `;
            roomChat.innerHTML = html;

            showMessageOfRoom(userId);
        }

        function showChatReceive(message, img) { // hien thi message nhan
            const showChat = document.getElementById("show-chat");
            let imgReceive = "";
            if (img == null) {
                imgReceive = "https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp";
            } else {
                imgReceive = `/storage/${img}`
            }
            // Tạo div cha
            let messageContainer = document.createElement('div');
            messageContainer.classList.add('d-flex', 'flex-row', 'justify-content-start', 'mb-4');

            // Tạo phần tử img cho avatar
            let avatar = document.createElement('img');
            avatar.setAttribute('src', imgReceive);
            avatar.setAttribute('alt', 'avatar 1');
            avatar.classList = ["rounded-circle"]
            avatar.style.width = '45px';
            avatar.style.height = '45px';

            // Tạo phần tử div cho message
            let messageBox = document.createElement('div');
            messageBox.classList.add('p-3', 'ms-3', "message");
            messageBox.style.borderRadius = '15px';
            messageBox.style.backgroundColor = 'rgba(57, 192, 237, .2)';

            // Tạo phần tử p cho nội dung tin nhắn
            let messageText = document.createElement('p');
            messageText.classList.add('small', 'mb-0');
            messageText.textContent = message;

            // Gắn các phần tử vào messageBox
            messageBox.appendChild(messageText);

            // Gắn avatar và messageBox vào messageContainer
            messageContainer.appendChild(avatar);
            messageContainer.appendChild(messageBox);

            // Cuộn xuống cuối mỗi khi có tin nhắn mới
            showChat.scrollTop = showChat.scrollHeight + 100;

            // Gắn messageContainer vào vị trí cần hiển thị (ví dụ là trong phần tử có id "chat-container")
            showChat.appendChild(messageContainer);

        }

        function showChatSend(message, image) { // hien thi message gui
            let imgSend = '';
            if (image == null) {
                imgSend = "https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp";
            } else {
                imgSend = `/storage/${image}`
            }
            const showChat = document.getElementById("show-chat");
            let messageContent = message;
            // Tạo các phần tử DOM
            let chatContainer = document.createElement("div");
            chatContainer.className = "d-flex flex-row justify-content-end mb-4";
            let messageBox = document.createElement("div");
            messageBox.className = "p-3 me-3 border bg-body-tertiary message";
            messageBox.style.borderRadius = "15px";
            let messageText = document.createElement("p");
            messageText.className = "small mb-0";
            messageText.textContent = messageContent;
            let avatar = document.createElement("img");
            avatar.src = imgSend;
            avatar.alt = "avatar 1";
            avatar.style.width = "45px";
            avatar.style.height = "45px";
            avatar.classList = ['rounded-circle'];
            // Ghép nối các phần tử lại với nhau
            messageBox.appendChild(messageText);
            chatContainer.appendChild(messageBox);
            chatContainer.appendChild(avatar);

            // Cuộn xuống cuối mỗi khi có tin nhắn mới
            showChat.scrollTop = showChat.scrollHeight + 100;
            // Thêm vào phần hiển thị chat
            showChat.appendChild(chatContainer);
        }

        function sendMessage(data) {
            window.axios.post("/chat-send", {
                data: data
            }).then((res) => {
                console.log(res)
            })
        }
    </script>
@endpush
