<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('manager.dashboard') }}" class="sidebar__main-logo"><img
                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('image')"></a>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('manager.dashboard') }}">
                    <a href="{{ route('manager.dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('manager.branch.index') }}">
                    <a href="{{ route('manager.branch.index') }}" class="nav-link ">
                        <i class="menu-icon las la-university"></i>
                        <span class="menu-title">@lang('Branch List')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('manager.staff*') }}">
                    <a href="{{ route('manager.staff.index') }}" class="nav-link ">
                        <i class="menu-icon las la-user-friends"></i>
                        <span class="menu-title">@lang('Manager Staff')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('manager.courier*', 3) }}">
                        <i class="menu-icon las la-university"></i>
                        <span class="menu-title">@lang('Manage Courier') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('manager.courier*', 2) }} ">
                        <ul>

                            <li class="sidebar-menu-item {{ menuActive('manager.courier.sentQueue') }}">
                                <a href="{{ route('manager.courier.sentQueue') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Sent In Queue')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.courier.dispatch') }}">
                                <a href="{{ route('manager.courier.dispatch') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Dispatched')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.courier.upcoming') }}">
                                <a href="{{ route('manager.courier.upcoming') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Upcoming')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.courier.deliveryInQueue') }}">
                                <a href="{{ route('manager.courier.deliveryInQueue') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Delivery In Queue')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.courier.delivered') }}">
                                <a href="{{ route('manager.courier.delivered') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Delivered')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.courier.sent') }}">
                                <a href="{{ route('manager.courier.sent') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Sent All Courier')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.courier.index') }}">
                                <a href="{{ route('manager.courier.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item  {{ menuActive('manager.branch.income') }}">
                    <a href="{{ route('manager.branch.income') }}" class="nav-link">
                        <i class="menu-icon las la-wallet"></i>
                        <span class="menu-title">@lang('Branch Income')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item  {{ menuActive('ticket*') }}">
                    <a href="{{ route('manager.ticket.index') }}" class="nav-link">
                        <i class="menu-icon las la-ticket-alt"></i>
                        <span class="menu-title">@lang('Support Ticket')</span>
                    </a>
                </li>
            </ul>
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{ __(systemDetails()['name']) }}</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div>
        </div>


        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{ __(systemDetails()['name']) }}</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->

@push('script')
    <script>
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    </script>
@endpush
