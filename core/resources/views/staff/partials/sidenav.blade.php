<div class="sidebar bg--dark">
    @php
        $upcomingCount = \App\Models\CourierInfo::where('receiver_branch_id', auth()->user()->id)
            ->where('status', 1)
            ->count();
        // $deliveryCount = \App\Models\CourierInfo::where('receiver_branch_id',)
    @endphp
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('staff.new_dashboard') }}" class="sidebar__main-logo"><img
                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('image')"></a>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('staff.dashboard') }}">
                    <a href="{{ route('staff.new_dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>
                @if(auth()->user()->branch->country == 'FRA')
                <li class="sidebar-menu-item {{ menuActive('staff.rdv*') }}">
                    <a href="{{ route('staff.rdv.list') }}" class="nav-link ">
                        <i class="menu-icon las la-shipping-fast"></i>
                        <span class="menu-title">@lang('RDV')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.demande.rdvclient')}}">
                    <a href="{{route('staff.demande.rdvclient')}}" class="nav-link"
                       data-default-url="{{ route('staff.demande.rdvclient') }}">
                        <i class="menu-icon las la-luggage-cart"></i>
                        <span class="menu-title">@lang('Demandes RDV')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.prospect*')}}">
                    <a href="{{route('staff.prospect.list')}}" class="nav-link"
                       data-default-url="{{ route('staff.prospect.list') }}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Prospects')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.mission*')}}">
                    <a href="{{route('staff.mission.index')}}" class="nav-link"
                       data-default-url="{{ route('staff.mission.index') }}">
                        <i class="menu-icon las la-people-carry"></i>
                        <span class="menu-title">@lang('Programmes')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.transactions.index')}}">
                    <a href="{{route('staff.transactions.index')}}" class="nav-link"
                       data-default-url="{{ route('staff.transactions.index') }}">
                        <i class="menu-icon las la-sliders-h"></i>
                        <span class="menu-title">@lang('Liste des Transactions')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.transfert.liste')}}">
                    <a href="{{route('staff.transfert.liste')}}" class="nav-link"
                       data-default-url="{{ route('staff.transfert.liste') }}">
                        <i class="menu-icon las la-clipboard-list"></i>
                        <span class="menu-title">@lang('Liste des Transferts')</span>
                    </a>
                </li>


                @endif

                @if(auth()->user()->branch->country == 'CIV')
                <li class="sidebar-menu-item {{menuActive('staff.transfert.receive')}}">
                    <a href="{{route('staff.transfert.receive')}}" class="nav-link"
                       data-default-url="{{ route('staff.transfert.receive') }}">
                        <i class="menu-icon las la-share"></i>
                        <span class="menu-title">@lang('Transfert Reçu')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.colis.nonpayes')}}">
                    <a href="{{route('staff.colis.nonpayes')}}" class="nav-link"
                       data-default-url="{{ route('staff.colis.nonpayes') }}">
                        <i class="menu-icon las la-clipboard-list"></i>
                        <span class="menu-title">@lang('Transferts Non Payes')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.bilan.encoursabidjan')}}">
                    <a href="{{route('staff.bilan.encoursabidjan')}}" class="nav-link"
                       data-default-url="{{ route('staff.bilan.encoursabidjan') }}">
                        <i class="menu-icon las la-euro-sign"></i>
                        <span class="menu-title">@lang('Encours')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.transfert.delivery')}}">
                    <a href="{{route('staff.transfert.delivery')}}" class="nav-link"
                       data-default-url="{{ route('staff.transfert.delivery') }}">
                        <i class="menu-icon las la-archive"></i>
                        <span class="menu-title">@lang('Transferts Livrés')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.prospect*')}}">
                    <a href="{{route('staff.prospect.list')}}" class="nav-link"
                       data-default-url="{{ route('staff.prospect.list') }}">
                        <i class="menu-icon las la-luggage-cart"></i>
                        <span class="menu-title">@lang('Reclamations')</span>
                    </a>
                </li>
                @endif
                 <li class="sidebar-menu-item {{menuActive('staff.transaction.list')}} ">
                                <a href="{{route('staff.transaction.list')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Mon Bilan Journalier')</span>
                                </a>
                            </li>
                @if(auth()->user()->username == 'christian' || auth()->user()->username == 'aminata' || auth()->user()->username == 'kanga' || auth()->user()->username == 'bertin' || auth()->user()->username == 'bagate' || auth()->user()->username == 'fatou' || auth()->user()->username == 'mouna' )
                            <li class="sidebar-menu-item {{menuActive('staff.transaction.agencelist')}} ">
                                <a href="{{route('staff.transaction.agencelist')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Bilan Agence')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('staff.transaction.depense')}} ">
                                <a href="{{route('staff.transaction.depense')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Depenses')</span>
                                </a>
                            </li>
                            @endif
                            <li class="sidebar-menu-item {{menuActive('staff.sms.rapport')}}">
                    <a href="{{route('staff.sms.rapport')}}" class="nav-link"
                       data-default-url="{{ route('staff.sms.rapport') }}">
                        <i class="menu-icon las la-sms"></i>
                        <span class="menu-title">@lang('Sms Rapport')</span>
                    </a>
                </li>
                @if( auth()->user()->username == 'bagate' || auth()->user()->username == 'mouna' )
                <li class="sidebar-menu-item {{menuActive('staff.customer.list')}}">
                    <a href="{{route('staff.customer.list')}}" class="nav-link"
                       data-default-url="{{ route('staff.customer.list') }}">
                        <i class="menu-icon las la-truck-loading"></i>
                        <span class="menu-title">@lang('Clients')</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->branch->country == 'FRA')
                <li class="sidebar-menu-item {{menuActive('staff.container*')}}">
                    <a href="{{route('staff.container.liste')}}" class="nav-link"
                       data-default-url="{{ route('staff.container.liste') }}">
                        <i class="menu-icon las la-ship"></i>
                        <span class="menu-title">@lang('Chargement')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('staff.suivi*')}}">
                    <a href="{{route('staff.suivi.liste')}}" class="nav-link"
                       data-default-url="{{ route('staff.suivi.liste') }}">
                        <i class="menu-icon las la-ship"></i>
                        <span class="menu-title">@lang('Suivi Conteneur')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.courier.sent.queue') }}">
                    <a href="{{ route('staff.courier.sent.queue') }}" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title">@lang('Sent In Queue')</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->branch->country == 'CIV')
                <li class="sidebar-menu-item {{menuActive('staff.container.liste_decharge')}}">
                    <a href="{{route('staff.container.liste_decharge')}}" class="nav-link"
                       data-default-url="{{ route('staff.container.liste_decharge') }}">
                        <i class="menu-icon las la-code-branch"></i>
                        <span class="menu-title">@lang('Conteneurs')</span>
                    </a>
                </li>
                @endif
                <!-- <li class="sidebar-menu-item {{ menuActive('staff.courier.sent.queue') }}">
                    <a href="{{ route('staff.courier.sent.queue') }}" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title">@lang('Sent In Queue')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.courier.create') }}">
                    <a href="{{ route('staff.courier.create') }}" class="nav-link ">
                        <i class="menu-icon las la-shipping-fast"></i>
                        <span class="menu-title">@lang('Send Courier')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.courier.sent.queue') }}">
                    <a href="{{ route('staff.courier.sent.queue') }}" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title">@lang('Sent In Queue')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('staff.courier.manage*', 3) }}">
                        <i class="menu-icon las la-sliders-h"></i>
                        <span class="menu-title">@lang('Manage Courier') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('staff.courier.manage*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('staff.courier.manage.sent.list') }}">
                                <a href="{{ route('staff.courier.manage.sent.list') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Total Sent')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('staff.courier.manage.delivered') }}">
                                <a href="{{ route('staff.courier.manage.delivered') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Total Delivered')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('staff.courier.manage.list') }}">
                                <a href="{{ route('staff.courier.manage.list') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Courier')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
                <!-- <li class="sidebar-menu-item {{ menuActive('staff.courier.create') }}">
                    <a href="{{ route('staff.courier.create') }}" class="nav-link ">
                        <i class="menu-icon las la-shipping-fast"></i>
                        <span class="menu-title">@lang('Send Courier')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.courier.sent.queue') }}">
                    <a href="{{ route('staff.courier.sent.queue') }}" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title">@lang('Sent In Queue')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.courier.dispatch') }}">
                    <a href="{{ route('staff.courier.dispatch') }}" class="nav-link ">
                        <i class="menu-icon las la-sync"></i>
                        <span class="menu-title">@lang('Shipping Courier') </span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.courier.upcoming') }}">
                    <a href="{{ route('staff.courier.upcoming') }}" class="nav-link ">
                        <i class="menu-icon las la-history"></i>
                        <span class="menu-title">@lang('Upcoming Courier') @if ($upcomingCount > 0)
                                <span class="menu-badge pill bg--danger ms-auto">{{ $upcomingCount }}</span>
                            @endif
                        </span>

                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.courier.delivery.queue') }}">
                    <a href="{{ route('staff.courier.delivery.queue') }}" class="nav-link ">
                        <i class="menu-icon lab la-accessible-icon"></i>
                        <span class="menu-title">@lang('Delivery in Queue')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('staff.courier.manage*', 3) }}">
                        <i class="menu-icon las la-sliders-h"></i>
                        <span class="menu-title">@lang('Manage Courier') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('staff.courier.manage*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('staff.courier.manage.sent.list') }}">
                                <a href="{{ route('staff.courier.manage.sent.list') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Total Sent')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('staff.courier.manage.delivered') }}">
                                <a href="{{ route('staff.courier.manage.delivered') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Total Delivered')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('staff.courier.manage.list') }}">
                                <a href="{{ route('staff.courier.manage.list') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Courier')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.branch.index') }}">
                    <a href="{{ route('staff.branch.index') }}" class="nav-link ">
                        <i class="menu-icon las la-university"></i>
                        <span class="menu-title">@lang('Branch List')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item  {{ menuActive('staff.cash.courier.income') }}">
                    <a href="{{ route('staff.cash.courier.income') }}" class="nav-link">
                        <i class="menu-icon las la-wallet"></i>
                        <span class="menu-title">@lang('Cash Collection')</span>
                    </a>
                </li> -->
                <li class="sidebar-menu-item  {{ menuActive('ticket*') }}">
                    <a href="{{ route('staff.ticket.index') }}" class="nav-link">
                        <i class="menu-icon las la-ticket-alt"></i>
                        <span class="menu-title">@lang('Support Ticket')</span>
                    </a>
                </li>

            </ul>
            <!-- <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{ __(systemDetails()['name']) }}</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div> -->
        </div>
        <!-- <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{ __(systemDetails()['name']) }}</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div>
        </div> -->
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
