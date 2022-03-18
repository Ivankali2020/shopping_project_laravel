<div class="app-sidebar sidebar-shadow">

    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button"
                    class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading ">Dashboards</li>

                <x-side-bar route="{{ route('home') }}" sidebarname="Dashboard" icon="pe-7s-display2 "  active="admin_home_active"/>
                <x-side-bar route="{{ route('category.index') }}" sidebarname="Create Category" icon="pe-7s-disk "  active="category_index_active"/>
                <x-side-bar route="{{ route('brand.index') }}" sidebarname="Create Brand" icon="pe-7s-disk "  active="brand_index_active"/>

                <li class="app-sidebar__heading">User Manager</li>
                <x-side-bar route="{{ route('user.create') }}" sidebarname="Create User" icon="pe-7s-user "  active="user_create_active"/>
                <x-side-bar route="{{ route('user.index') }}" sidebarname="List User" icon="pe-7s-menu "  active="user_index_active"/>

                <li class="app-sidebar__heading">Product Manager</li>
                <x-side-bar route="{{ route('product.create') }}" sidebarname="Create Product" icon="pe-7s-magic-wand "  active="product_create_active"/>
                <x-side-bar route="{{ route('product.index') }}" sidebarname="Product List" icon="pe-7s-menu "  active="product_index_active"/>

                <li class="app-sidebar__heading">Order Manager</li>
                <x-side-bar route="{{ route('order.index') }}" sidebarname=" Order List" icon="pe-7s-box2"  active="order_index_active"/>
                <x-side-bar route="{{ route('product.barcode') }}" sidebarname="Barcodes" icon="pe-7s-box2"  active="barcode_index_active"/>



            </ul>
        </div>
    </div>
</div>

