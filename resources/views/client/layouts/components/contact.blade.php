{{-- @push('css') --}}
<style>
    .contact-button {
        position: fixed;
        bottom: 80px;
        right: 40px;
        z-index: 1000;
    }

    .contact-button-chat {
        position: fixed;
        bottom: 10rem;
        right: 4rem;
        z-index: 1000;
    }

    .contact-icon {
        background-color: #CCA270;
        color: white;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
    }

    .contact-icon:hover {
        transform: scale(1.1);
    }

    .contact-options {
        list-style: none;
        margin: 0;
        padding: 0;
        position: absolute;
        bottom: 0;
        right: 60px;
        display: flex;
        gap: 10px;
        opacity: 0;
        transform: translateX(20px);
        transition: opacity 0.3s, transform 0.3s;
    }

    .contact-button:hover .contact-options {
        opacity: 1;
        transform: translateX(0);
    }

    .contact-options li {
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .contact-options li svg {
        width: 40px;
        height: 40px;
    }

    /* chat form  */
    .chat-card {
        width: 400px;
        min-height: 10rem;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /*overflow: hidden;*/
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        max-height: 30rem;
    }

    .chat-header {
        padding: 10px;
        background-color: #CCA270;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header .h2 {
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }

    .chat-body {
        padding: 20px;
        position: relative;
        top: 0;
        height: 100%;
        overflow-y: auto;
    }

    .form-button button {
        border: none;
        padding: 3px 12px;
        background-color: #ffffff1a;
    }

    .form-button button:hover {
        background-color: #fff3;
    }

    .message {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
        max-width: 100%;
        word-wrap: break-word;
        /* Đảm bảo các từ dài sẽ xuống dòng */
        overflow-wrap: break-word;
        /* Phòng tránh các từ dài không gãy xuống dòng */

        display: flex;
        flex-direction: column-reverse;
    }

    .incoming {
        background-color: rgba(57, 192, 237, .2);
    }

    .outgoing {
        background-color: rgba(248, 249, 250, 1);
        text-align: right;
    }

    .message p {
        font-size: 14px;
        color: #333;
        margin: 0;
    }

    .chat-footer {
        padding: 10px;
        background-color: #CCA270;
        display: flex;
    }

    .chat-footer input[type="text"] {
        flex-grow: 1;
        padding: 5px;
        border: none;
        border-radius: 3px;
    }

    .chat-footer button {
        padding: 5px 10px;
        border: none;
        background-color: #4285f4;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .chat-footer button:hover {
        background-color: #0f9d58;
    }

    @keyframes chatAnimation {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-card .message {
        animation: chatAnimation 0.3s ease-in-out;
        animation-fill-mode: both;
        animation-delay: 0.1s;
    }

    .chat-card .message:nth-child(even) {
        animation-delay: 0.2s;
    }

    .chat-card .message:nth-child(odd) {
        animation-delay: 0.3s;
    }


    @media (max-width: 768px) {
        .contact-button {
            position: fixed;
            bottom: 130px;
            right: 15px;
            z-index: 1000;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
        }
    }
</style>
{{-- @endpush --}}

<div class="contact-button">
    <div class="contact-icon"><i class="fa fa-volume-control-phone" aria-hidden="true"></i></div>
    <ul class="contact-options">
        <li>
            <a href="https://zalo.me/" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48">
                    <path fill="#2962ff"
                        d="M15,36V6.827l-1.211-0.811C8.64,8.083,5,13.112,5,19v10c0,7.732,6.268,14,14,14h10	c4.722,0,8.883-2.348,11.417-5.931V36H15z">
                    </path>
                    <path fill="#eee"
                        d="M29,5H19c-1.845,0-3.601,0.366-5.214,1.014C10.453,9.25,8,14.528,8,19	c0,6.771,0.936,10.735,3.712,14.607c0.216,0.301,0.357,0.653,0.376,1.022c0.043,0.835-0.129,2.365-1.634,3.742	c-0.162,0.148-0.059,0.419,0.16,0.428c0.942,0.041,2.843-0.014,4.797-0.877c0.557-0.246,1.191-0.203,1.729,0.083	C20.453,39.764,24.333,40,28,40c4.676,0,9.339-1.04,12.417-2.916C42.038,34.799,43,32.014,43,29V19C43,11.268,36.732,5,29,5z">
                    </path>
                    <path fill="#2962ff"
                        d="M36.75,27C34.683,27,33,25.317,33,23.25s1.683-3.75,3.75-3.75s3.75,1.683,3.75,3.75	S38.817,27,36.75,27z M36.75,21c-1.24,0-2.25,1.01-2.25,2.25s1.01,2.25,2.25,2.25S39,24.49,39,23.25S37.99,21,36.75,21z">
                    </path>
                    <path fill="#2962ff" d="M31.5,27h-1c-0.276,0-0.5-0.224-0.5-0.5V18h1.5V27z"></path>
                    <path fill="#2962ff"
                        d="M27,19.75v0.519c-0.629-0.476-1.403-0.769-2.25-0.769c-2.067,0-3.75,1.683-3.75,3.75	S22.683,27,24.75,27c0.847,0,1.621-0.293,2.25-0.769V26.5c0,0.276,0.224,0.5,0.5,0.5h1v-7.25H27z M24.75,25.5	c-1.24,0-2.25-1.01-2.25-2.25S23.51,21,24.75,21S27,22.01,27,23.25S25.99,25.5,24.75,25.5z">
                    </path>
                    <path fill="#2962ff"
                        d="M21.25,18h-8v1.5h5.321L13,26h0.026c-0.163,0.211-0.276,0.463-0.276,0.75V27h7.5	c0.276,0,0.5-0.224,0.5-0.5v-1h-5.321L21,19h-0.026c0.163-0.211,0.276-0.463,0.276-0.75V18z">
                    </path>
                </svg>
            </a>
        </li>
        <li>
            <a href="https://facebook.com/" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                    viewBox="0 0 48 48">
                    <radialGradient id="8O3wK6b5ASW2Wn6hRCB5xa_YFbzdUk7Q3F8_gr1" cx="11.087" cy="7.022"
                        r="47.612" gradientTransform="matrix(1 0 0 -1 0 50)" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#1292ff"></stop>
                        <stop offset=".079" stop-color="#2982ff"></stop>
                        <stop offset=".23" stop-color="#4e69ff"></stop>
                        <stop offset=".351" stop-color="#6559ff"></stop>
                        <stop offset=".428" stop-color="#6d53ff"></stop>
                        <stop offset=".754" stop-color="#df47aa"></stop>
                        <stop offset=".946" stop-color="#ff6257"></stop>
                    </radialGradient>
                    <path fill="url(#8O3wK6b5ASW2Wn6hRCB5xa_YFbzdUk7Q3F8_gr1)"
                        d="M44,23.5C44,34.27,35.05,43,24,43c-1.651,0-3.25-0.194-4.784-0.564	c-0.465-0.112-0.951-0.069-1.379,0.145L13.46,44.77C12.33,45.335,11,44.513,11,43.249v-4.025c0-0.575-0.257-1.111-0.681-1.499	C6.425,34.165,4,29.11,4,23.5C4,12.73,12.95,4,24,4S44,12.73,44,23.5z">
                    </path>
                    <path
                        d="M34.992,17.292c-0.428,0-0.843,0.142-1.2,0.411l-5.694,4.215	c-0.133,0.1-0.28,0.15-0.435,0.15c-0.15,0-0.291-0.047-0.41-0.136l-3.972-2.99c-0.808-0.601-1.76-0.918-2.757-0.918	c-1.576,0-3.025,0.791-3.876,2.116l-1.211,1.891l-4.12,6.695c-0.392,0.614-0.422,1.372-0.071,2.014	c0.358,0.654,1.034,1.06,1.764,1.06c0.428,0,0.843-0.142,1.2-0.411l5.694-4.215c0.133-0.1,0.28-0.15,0.435-0.15	c0.15,0,0.291,0.047,0.41,0.136l3.972,2.99c0.809,0.602,1.76,0.918,2.757,0.918c1.576,0,3.025-0.791,3.876-2.116l1.211-1.891	l4.12-6.695c0.392-0.614,0.422-1.372,0.071-2.014C36.398,17.698,35.722,17.292,34.992,17.292L34.992,17.292z"
                        opacity=".05"></path>
                    <path
                        d="M34.992,17.792c-0.319,0-0.63,0.107-0.899,0.31l-5.697,4.218	c-0.216,0.163-0.468,0.248-0.732,0.248c-0.259,0-0.504-0.082-0.71-0.236l-3.973-2.991c-0.719-0.535-1.568-0.817-2.457-0.817	c-1.405,0-2.696,0.705-3.455,1.887l-1.21,1.891l-4.115,6.688c-0.297,0.465-0.32,1.033-0.058,1.511c0.266,0.486,0.787,0.8,1.325,0.8	c0.319,0,0.63-0.107,0.899-0.31l5.697-4.218c0.216-0.163,0.468-0.248,0.732-0.248c0.259,0,0.504,0.082,0.71,0.236l3.973,2.991	c0.719,0.535,1.568,0.817,2.457,0.817c1.405,0,2.696-0.705,3.455-1.887l1.21-1.891l4.115-6.688c0.297-0.465,0.32-1.033,0.058-1.511	C36.051,18.106,35.531,17.792,34.992,17.792L34.992,17.792z"
                        opacity=".07"></path>
                    <path fill="#fff"
                        d="M34.394,18.501l-5.7,4.22c-0.61,0.46-1.44,0.46-2.04,0.01L22.68,19.74	c-1.68-1.25-4.06-0.82-5.19,0.94l-1.21,1.89l-4.11,6.68c-0.6,0.94,0.55,2.01,1.44,1.34l5.7-4.22c0.61-0.46,1.44-0.46,2.04-0.01	l3.974,2.991c1.68,1.25,4.06,0.82,5.19-0.94l1.21-1.89l4.11-6.68C36.434,18.901,35.284,17.831,34.394,18.501z">
                    </path>
                </svg>
            </a>
        </li>

        {{--       tam thoi phai co tai khoan thi moi hien --}}
        @if (Auth::id())
            <li>
                <a target="_blank" data-form="#form-chat" id="button-chat">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                        viewBox="0 0 40 40">
                        <path fill="#8bb7f0"
                            d="M4.893,36.471c0.787-1.35,1.711-3,2.56-4.577l0.199-0.37l-0.329-0.26 C3.568,28.296,1.5,24.296,1.5,20C1.5,11.453,9.799,4.5,20,4.5S38.5,11.453,38.5,20S30.201,35.5,20,35.5 c-2.173,0-4.339-0.332-6.436-0.985l-0.163-0.051l-0.16,0.06C10.296,35.618,7.254,36.322,4.893,36.471z">
                        </path>
                        <path fill="#4e7ab5"
                            d="M20,5c9.925,0,18,6.729,18,15s-8.075,15-18,15c-2.123,0-4.239-0.324-6.287-0.962l-0.326-0.102 l-0.32,0.119c-2.521,0.936-5.108,1.583-7.26,1.831c0.671-1.171,1.402-2.487,2.086-3.756l0.398-0.739l-0.658-0.52 C4,28.001,2,24.14,2,20C2,11.729,10.075,5,20,5 M20,4C9.507,4,1,11.163,1,20c0,4.601,2.32,8.737,6.013,11.656 C5.947,33.635,4.837,35.596,4,37c2.597,0,6.172-0.803,9.415-2.007C15.47,35.633,17.681,36,20,36c10.493,0,19-7.163,19-16 S30.493,4,20,4L20,4z">
                        </path>
                    </svg>
                </a>
            </li>
        @endif
    </ul>

</div>
<div class="chat-card contact-button-chat" id="form-chat" data-hidden="true" style="display:none">
    <div class="chat-header">
        <div class="h2">Gumdam Win</div>
        <div class="form-button">
            <button class="button-revert" type="button">
                <i class="fa-solid fa-repeat"></i>
            </button>
            <button class="button-minus" type="button">
                <i class="fa-solid fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="chat-body" id="chat-body">
    </div>
    <form class="chat-footer" id="client-chat">
        <input placeholder="Nhập tin nhắn" type="text" id="message" style="padding-right: 3.75rem">
        <p id="char-count"
            style="position: absolute;
                right: 3.5rem;
                bottom: 1.75rem;
                font-size: 14px;
                ">
            0/200</p>
        <button type="submit">
            <img width="20" height="20" src="https://img.icons8.com/color/48/sent--v2.png" alt="sent--v2" />

        </button>

    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // an hien form chat
            const userId = {{ Auth::check() ? Auth::id() : 'null' }};
            const btnFormChat = document.getElementById("button-chat");
            const btnMinus = document.querySelector(".button-minus");
            const btnRevert = document.querySelector(".button-revert");
            const btnClientChat = document.getElementById("client-chat");

            // console.log(btnMinus)
            btnMinus.addEventListener("click", function() {
                toogleFormChat();

            });
            // xoa tin nhan
            btnRevert.addEventListener("click", () => {
                deleteMessage(userId);
                document.getElementById("chat-body").innerHTML = '';
            })
            // hien form chat
            btnFormChat.addEventListener("click", function(e) {
                toogleFormChat()
                showAllMessage(userId);

            });


            // validate ky tu  tin nhan nguoi dung
            const chatInput = document.getElementById('message');
            const charCount = document.getElementById('char-count');
            const maxChars = 200;

            // Cập nhật số ký tự và xử lý giới hạn
            const updateCharacterCount = () => {
                const currentLength = chatInput.value.length;

                if (currentLength > maxChars) {
                    // Nếu vượt quá, cắt nội dung và hiển thị thông báo
                    chatInput.value = chatInput.value.substring(0, maxChars);

                }
                charCount.textContent = `${chatInput.value.length}/${maxChars}`;
            };

            // Lắng nghe sự kiện 'input' và 'paste'
            chatInput.addEventListener('input', updateCharacterCount);

            chatInput.addEventListener('paste', (event) => {
                // Xử lý nội dung dán
                const pasteContent = (event.clipboardData || window.clipboardData).getData('text');
                const newContent = chatInput.value + pasteContent;

                if (newContent.length > maxChars) {
                    event.preventDefault(); // Ngăn không cho dán vượt quá
                    chatInput.value = newContent.substring(0, maxChars); // Chỉ giữ lại tối đa 200 ký tự
                }

                charCount.textContent = `${chatInput.value.length}/${maxChars}`;
            });



            // SU LY SU KIEN CHAT REALTIME
            console.log("User ID:", userId);

            window.Echo.private(`chat.${userId}`)
                .listen("ChatMessage", function(data) {
                    const message = data.message;
                    console.log({
                        message
                    });
                    if (message.sender_id == userId) {
                        showChatSend(message.message);
                    } else {
                        showChatReceive(message.message);
                    }
                })

            btnClientChat.addEventListener("submit", (e) => {
                e.preventDefault();
                const message = document.getElementById("message");
                // console.log(message.value);

                window.axios.post("/api/chat-send", {
                    message: message.value,
                    sender_id: userId,
                    receiver_id: null
                })
                message.value = '';
                document.getElementById('char-count').textContent = '0/200';
            });


        });

        function validateInputMessage() {
            const chatInput = document.getElementById('message');
            const charCount = document.getElementById('char-count');
            const maxChars = 200;

            chatInput.addEventListener('input', () => {
                if (chatInput.value.length > maxChars) {
                    // alert("Tin nhắn không được vượt quá 200 ký tự!");
                    chatInput.value = chatInput.value.substring(0, maxChars);
                    return;
                }
                const currentLength = chatInput.value.length;
                charCount.textContent = `${currentLength}/${maxChars}`;
            });

        }

        function deleteMessage(userId) {
            window.axios.delete("/api/chat-messages", {
                data: {
                    userId: userId
                }
            });
        }

        function showAllMessage(userId) {
            window.axios.get("/api/chat-messages", {
                params: {
                    userId: userId
                }
            }).then((data) => {
                const messages = data.data.messages;

                console.log(messages)
                messages.forEach((message, index) => {
                    console.log(message)
                    if (message.sender_id == userId) {
                        showChatSend(message.message);
                    } else {
                        showChatReceive(message.message)
                    }
                });

            })
        }

        function showChatReceive(message) {
            const showChat = document.getElementById("chat-body");
            let divElement = document.createElement("div");
            let pElement = document.createElement("p");
            divElement.className = "message incoming";
            pElement.textContent = message;
            divElement.appendChild(pElement);
            showChat.appendChild(divElement);

            // Cuộn đến tin nhắn mới nhất
            showChat.scrollTop = showChat.scrollHeight;
        }

        function showChatSend(message) {
            const showChat = document.getElementById("chat-body");
            let divElement = document.createElement("div");
            let pElement = document.createElement("p");
            divElement.className = "message outgoing";
            pElement.textContent = message;
            divElement.appendChild(pElement);
            showChat.appendChild(divElement);
            // Cuộn đến tin nhắn mới nhất
            showChat.scrollTop = showChat.scrollHeight;
        }

        function toogleFormChat() { // AN HIEN FORM CHAT
            let formChat = document.getElementById("form-chat")
            let hidden = formChat.dataset.hidden;
            console.log(hidden)
            if (hidden == 'true') {
                formChat.dataset.hidden = 'false';
                formChat.style.display = "";
            } else {
                console.log("hidden")
                formChat.dataset.hidden = "true";
                formChat.style.display = "none";
            }
        }
    </script>
@endpush
