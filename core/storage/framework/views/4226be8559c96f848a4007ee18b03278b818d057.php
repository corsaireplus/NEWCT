<div class="sidebar bg--dark">
    <?php
        $upcomingCount = \App\Models\CourierInfo::where('receiver_branch_id', auth()->user()->id)
            ->where('status', 1)
            ->count();
        // $deliveryCount = \App\Models\CourierInfo::where('receiver_branch_id',)
    ?>
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="<?php echo e(route('staff.new_dashboard')); ?>" class="sidebar__main-logo"><img
                    src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>"></a>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.dashboard')); ?>">
                    <a href="<?php echo e(route('staff.new_dashboard')); ?>" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Dashboard'); ?></span>
                    </a>
                </li>
                <?php if(auth()->user()->branch->country == 'FRA'): ?>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.rdv*')); ?>">
                    <a href="<?php echo e(route('staff.rdv.list')); ?>" class="nav-link ">
                        <i class="menu-icon las la-shipping-fast"></i>
                        <span class="menu-title"><?php echo app('translator')->get('RDV'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.demande.rdvclient')); ?>">
                    <a href="<?php echo e(route('staff.demande.rdvclient')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.demande.rdvclient')); ?>">
                        <i class="menu-icon las la-luggage-cart"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Demandes RDV'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.prospect*')); ?>">
                    <a href="<?php echo e(route('staff.prospect.list')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.prospect.list')); ?>">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Prospects'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.mission*')); ?>">
                    <a href="<?php echo e(route('staff.mission.index')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.mission.index')); ?>">
                        <i class="menu-icon las la-people-carry"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Programmes'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.transactions.index')); ?>">
                    <a href="<?php echo e(route('staff.transactions.index')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.transactions.index')); ?>">
                        <i class="menu-icon las la-sliders-h"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Liste des Transactions'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.transfert.liste')); ?>">
                    <a href="<?php echo e(route('staff.transfert.liste')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.transfert.liste')); ?>">
                        <i class="menu-icon las la-clipboard-list"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Liste des Transferts'); ?></span>
                    </a>
                </li>


                <?php endif; ?>

                <?php if(auth()->user()->branch->country == 'CIV'): ?>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.transfert.receive')); ?>">
                    <a href="<?php echo e(route('staff.transactions.receive')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.transactions.receive')); ?>">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Liste Transactions'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.transfert.receive')); ?>">
                    <a href="<?php echo e(route('staff.transfert.receive')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.transfert.receive')); ?>">
                        <i class="menu-icon las la-share"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Transfert Reçu'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.colis.nonpayes')); ?>">
                    <a href="<?php echo e(route('staff.colis.nonpayes')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.colis.nonpayes')); ?>">
                        <i class="menu-icon las la-clipboard-list"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Transferts Non Payes'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.bilan.encoursabidjan')); ?>">
                    <a href="<?php echo e(route('staff.bilan.encoursabidjan')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.bilan.encoursabidjan')); ?>">
                        <i class="menu-icon las la-euro-sign"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Encours'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.transfert.delivery')); ?>">
                    <a href="<?php echo e(route('staff.transfert.delivery')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.transfert.delivery')); ?>">
                        <i class="menu-icon las la-archive"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Transferts Livrés'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.prospect*')); ?>">
                    <a href="<?php echo e(route('staff.prospect.list')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.prospect.list')); ?>">
                        <i class="menu-icon las la-luggage-cart"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Reclamations'); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                 <li class="sidebar-menu-item <?php echo e(menuActive('staff.transaction.list')); ?> ">
                                <a href="<?php echo e(route('staff.transaction.list')); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Mon Bilan Journalier'); ?></span>
                                </a>
                            </li>
                <?php if(auth()->user()->username == 'christian' || auth()->user()->username == 'aminata' || auth()->user()->username == 'kanga' || auth()->user()->username == 'bertin' || auth()->user()->username == 'bagate' || auth()->user()->username == 'fatou' || auth()->user()->username == 'mouna' ): ?>
                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.transaction.agencelist')); ?> ">
                                <a href="<?php echo e(route('staff.transaction.agencelist')); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Bilan Agence'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.transaction.depense')); ?> ">
                                <a href="<?php echo e(route('staff.transaction.depense')); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Depenses'); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.sms.rapport')); ?>">
                    <a href="<?php echo e(route('staff.sms.rapport')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.sms.rapport')); ?>">
                        <i class="menu-icon las la-sms"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Sms Rapport'); ?></span>
                    </a>
                </li>
                <?php if( auth()->user()->username == 'bagate' || auth()->user()->username == 'mouna' ): ?>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.customer.list')); ?>">
                    <a href="<?php echo e(route('staff.customer.list')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.customer.list')); ?>">
                        <i class="menu-icon las la-truck-loading"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Clients'); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()->branch->country == 'FRA'): ?>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.conteneurs*')); ?>">
                    <a href="<?php echo e(route('staff.conteneurs.index')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.conteneurs.index')); ?>">
                        <i class="menu-icon las la-ship"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Conteneurs'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.container*')); ?>">
                    <a href="<?php echo e(route('staff.container.liste')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.container.liste')); ?>">
                        <i class="menu-icon las la-ship"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Chargement'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.suivi*')); ?>">
                    <a href="<?php echo e(route('staff.suivi.liste')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.suivi.liste')); ?>">
                        <i class="menu-icon las la-ship"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Suivi Conteneur'); ?></span>
                    </a>
                </li>
                <!-- <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.sent.queue')); ?>">
                    <a href="<?php echo e(route('staff.courier.sent.queue')); ?>" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Sent In Queue'); ?></span>
                    </a>
                </li> -->
                <?php endif; ?>
                <?php if(auth()->user()->branch->country == 'CIV'): ?>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.conteneurs.conteneureceive')); ?>">
                    <a href="<?php echo e(route('staff.conteneurs.conteneureceive')); ?>" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Déchargements'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.container.liste_decharge')); ?>">
                    <a href="<?php echo e(route('staff.container.liste_decharge')); ?>" class="nav-link"
                       data-default-url="<?php echo e(route('staff.container.liste_decharge')); ?>">
                        <i class="menu-icon las la-code-branch"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Conteneurs'); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.sent.queue')); ?>">
                    <a href="<?php echo e(route('staff.courier.sent.queue')); ?>" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Sent In Queue'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.create')); ?>">
                    <a href="<?php echo e(route('staff.courier.create')); ?>" class="nav-link ">
                        <i class="menu-icon las la-shipping-fast"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Send Courier'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.sent.queue')); ?>">
                    <a href="<?php echo e(route('staff.courier.sent.queue')); ?>" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Sent In Queue'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php echo e(menuActive('staff.courier.manage*', 3)); ?>">
                        <i class="menu-icon las la-sliders-h"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Manage Courier'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('staff.courier.manage*', 2)); ?> ">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.manage.sent.list')); ?>">
                                <a href="<?php echo e(route('staff.courier.manage.sent.list')); ?>" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Total Sent'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.manage.delivered')); ?>">
                                <a href="<?php echo e(route('staff.courier.manage.delivered')); ?>" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Total Delivered'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.manage.list')); ?>">
                                <a href="<?php echo e(route('staff.courier.manage.list')); ?>" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Courier'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
                <!-- <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.create')); ?>">
                    <a href="<?php echo e(route('staff.courier.create')); ?>" class="nav-link ">
                        <i class="menu-icon las la-shipping-fast"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Send Courier'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.sent.queue')); ?>">
                    <a href="<?php echo e(route('staff.courier.sent.queue')); ?>" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Sent In Queue'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.dispatch')); ?>">
                    <a href="<?php echo e(route('staff.courier.dispatch')); ?>" class="nav-link ">
                        <i class="menu-icon las la-sync"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Shipping Courier'); ?> </span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.upcoming')); ?>">
                    <a href="<?php echo e(route('staff.courier.upcoming')); ?>" class="nav-link ">
                        <i class="menu-icon las la-history"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Upcoming Courier'); ?> <?php if($upcomingCount > 0): ?>
                                <span class="menu-badge pill bg--danger ms-auto"><?php echo e($upcomingCount); ?></span>
                            <?php endif; ?>
                        </span>

                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.delivery.queue')); ?>">
                    <a href="<?php echo e(route('staff.courier.delivery.queue')); ?>" class="nav-link ">
                        <i class="menu-icon lab la-accessible-icon"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Delivery in Queue'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php echo e(menuActive('staff.courier.manage*', 3)); ?>">
                        <i class="menu-icon las la-sliders-h"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Manage Courier'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('staff.courier.manage*', 2)); ?> ">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.manage.sent.list')); ?>">
                                <a href="<?php echo e(route('staff.courier.manage.sent.list')); ?>" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Total Sent'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.manage.delivered')); ?>">
                                <a href="<?php echo e(route('staff.courier.manage.delivered')); ?>" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Total Delivered'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('staff.courier.manage.list')); ?>">
                                <a href="<?php echo e(route('staff.courier.manage.list')); ?>" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Courier'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('staff.branch.index')); ?>">
                    <a href="<?php echo e(route('staff.branch.index')); ?>" class="nav-link ">
                        <i class="menu-icon las la-university"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Branch List'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item  <?php echo e(menuActive('staff.cash.courier.income')); ?>">
                    <a href="<?php echo e(route('staff.cash.courier.income')); ?>" class="nav-link">
                        <i class="menu-icon las la-wallet"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Cash Collection'); ?></span>
                    </a>
                </li> -->
                <li class="sidebar-menu-item  <?php echo e(menuActive('ticket*')); ?>">
                    <a href="<?php echo e(route('staff.ticket.index')); ?>" class="nav-link">
                        <i class="menu-icon las la-ticket-alt"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Support Ticket'); ?></span>
                    </a>
                </li>

            </ul>
            <!-- <div class="text-center mb-3 text-uppercase">
                <span class="text--primary"><?php echo e(__(systemDetails()['name'])); ?></span>
                <span class="text--success"><?php echo app('translator')->get('V'); ?><?php echo e(systemDetails()['version']); ?> </span>
            </div> -->
        </div>
        <!-- <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary"><?php echo e(__(systemDetails()['name'])); ?></span>
                <span class="text--success"><?php echo app('translator')->get('V'); ?><?php echo e(systemDetails()['version']); ?> </span>
            </div>
        </div> -->
    </div>
</div>
<!-- sidebar end -->

<?php $__env->startPush('script'); ?>
    <script>
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/partials/sidenav.blade.php ENDPATH**/ ?>