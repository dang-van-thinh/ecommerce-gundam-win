<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="fw-bold">
                    <a href=""><i class="menu-icon fa fa-home"></i>Trang chủ </a>
                </li>
                {{-- <li class="menu-title">UI elements</li><!-- /.menu-title --> --}}

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="menu-icon fa fa-book"></i>QL Khóa học</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="">Mẫu</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="menu-icon fa fa-book"></i>QL Danh mục</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{route('category-product.index')}}">Danh mục sản phẩm</a></li>
                        <li><i class="fa fa-list"></i><a href="{{route('category-article.index')}}">Danh mục bài viết</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</aside>
