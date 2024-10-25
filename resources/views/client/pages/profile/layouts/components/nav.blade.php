<div class="left-dashboard-show"><button class="btn btn_black sm bg-primary rounded">Show
        Menu</button></div>
<div class="dashboard-left-sidebar sticky">
    <div class="profile-box">
        <div class="profile-bg-img"></div>
        <div class="dashboard-left-sidebar-close"><i class="fa-solid fa-xmark"></i></div>
        <div class="profile-contain">
            <div class="profile-image"> <img class="img-fluid" src="/template/client/assets/images/user/12.jpg"
                    alt=""></div>
            <div class="profile-name">
                <h4>John Doe</h4>
                <h6>john.customer@example.com</h6><span data-bs-toggle="modal" data-bs-target="#edit-box"
                    title="Quick View" tabindex="0">Edit Profile</span>
            </div>
        </div>
    </div>
    <ul class="nav flex-column nav-pills dashboard-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <li>
            <a href="{{ route('profile.infomation') }}" class="nav-link">
                <i class="iconsax" data-icon="home-1"></i>
                Thông tin cá nhân
            </a>
        </li>

        <li>
            <a href="{{ route('profile.order-history') }}" class="nav-link">
                <i class="iconsax" data-icon="receipt-square"></i>
                Lịch sử đơn hàng</a>
        </li>

        <li>
            <a href="{{ route('profile.address') }}" class="nav-link">
                <i class="iconsax" data-icon="cue-cards"></i>
                Địa chỉ
            </a>
        </li>
        {{-- <li>
            <button class="nav-link" id="wishlist-tab" data-bs-toggle="pill" data-bs-target="#wishlist" role="tab"
                aria-controls="wishlist" aria-selected="false"> <i class="iconsax" data-icon="heart"></i>Wishlist
            </button>
        </li> --}}
        {{-- <li>
            <button class="nav-link" id="notifications-tab" data-bs-toggle="pill" data-bs-target="#notifications"
                role="tab" aria-controls="notifications" aria-selected="false"><i class="iconsax"
                    data-icon="lamp-2"></i>Notifications
            </button>
        </li> --}}
        {{-- <li>
            <button class="nav-link" id="saved-card-tab" data-bs-toggle="pill" data-bs-target="#saved-card"
                role="tab" aria-controls="saved-card" aria-selected="false"> <i class="iconsax"
                    data-icon="bank-card"></i>Saved
                Card</button>
        </li> --}}

        {{-- <li>
            <button class="nav-link" id="privacy-tab" data-bs-toggle="pill" data-bs-target="#privacy" role="tab"
                aria-controls="privacy" aria-selected="false">
                <i class="iconsax" data-icon="security-user"></i>Privacy</button>
        </li> --}}
    </ul>
    <div class="logout-button"> <a class="btn btn_black sm" data-bs-toggle="modal" data-bs-target="#Confirmation-modal"
            title="Quick View" tabindex="0">
            <i class="iconsax me-1" data-icon="logout-1"></i> Đăng xuất </a>
    </div>
</div>