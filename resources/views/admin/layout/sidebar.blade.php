        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ asset('admin/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">Rocker</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="{{ route('admin-dashboard') }}">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>

                </li>
                <li>
                    <a href="{{ route('user-list') }}">
                        <div class="parent-icon"><i class="bx bx-lock"></i>
                        </div>
                        <div class="menu-title">User List</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('rate-index') }}">
                        <div class="parent-icon"><i class="bx bx-category"></i>
                        </div>
                        <div class="menu-title">Rate</div>
                    </a>
                </li>

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
                        </div>
                        <div class="menu-title">Product</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('product-create') }}"><i class='bx bx-radio-circle'></i>Add Product</a>
                        </li>
                        <li> <a href="{{ route('product-index') }}"><i class='bx bx-radio-circle'></i>All
                                Products</a>
                        </li>

                    </ul>
                </li>



            </ul>
            <!--end navigation-->
        </div>
