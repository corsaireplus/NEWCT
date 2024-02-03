<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {

    //Staff Login
    Route::controller('LoginController')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login');
        Route::get('logout', 'logout')->name('logout');
    });
    //Staff Password Forgot
    Route::controller('ForgotPasswordController')->name('password.')->prefix('password')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });
    //Manager Password Rest
    Route::controller('ResetPasswordController')->name('password.')->prefix('password')->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('reset.form');
        Route::post('password/reset/change', 'reset')->name('change');
    });
});

Route::middleware('auth')->group(function () {
    Route::middleware(['check.status'])->group(function () {
        Route::middleware('staff')->group(function () {
            //Home Controller
            Route::controller('StaffController')->group(function () {
                Route::get('dashboard', 'dashboard')->name('new_dashboard');
                Route::get('password', 'password')->name('password');
                Route::get('profile', 'profile')->name('profile');
                Route::post('profile/update', 'profileUpdate')->name('profile.update.data');
                Route::post('password/update', 'passwordUpdate')->name('password.update.data');
                Route::post('ticket/delete/{id}', 'ticketDelete')->name('ticket.delete');

                //Manage Branch
                Route::name('branch.')->prefix('branch')->group(function () {
                    Route::get('list', 'branchList')->name('index');
                    Route::get('income', 'branchIncome')->name('income');
                });
            });
            Route::controller('CourierController')->name('courier.')->prefix('courier')->group(function () {
                Route::get('send', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::get('invoice/{id}', 'invoice')->name('invoice');
                Route::get('delivery/list', 'delivery')->name('delivery.list');
                Route::get('details/{id}', 'details')->name('details');
                Route::post('payment', 'payment')->name('payment');
                Route::post('delivery/store', 'deliveryStore')->name('delivery');
                Route::get('list', 'courierList')->name('manage.list');
                Route::get('date/search', 'courierDateSearch')->name('date.search');
                Route::get('search', 'courierSearch')->name('search');
                Route::get('send/list', 'sentCourierList')->name('manage.sent.list');
                Route::get('received/list', 'receivedCourierList')->name('received.list');
                //New Route
                Route::get('sent/queue', 'sentQueue')->name('sent.queue');
                Route::post('dispatch-all/', 'courierAllDispatch')->name('dispatch.all');
                Route::get('dispatch', 'courierDispatch')->name('dispatch');
                Route::post('status/{id}', 'dispatched')->name('dispatched');
                Route::get('upcoming', 'upcoming')->name('upcoming');
                Route::post('receive/{id}', 'receive')->name('receive');
                Route::get('delivery/queue', 'deliveryQueue')->name('delivery.queue');
                Route::get('delivery/list/total', 'delivered')->name('manage.delivered');
            });

            Route::controller('CourierController')->prefix('cash')->group(function () {
                Route::get('collection', 'cash')->name('cash.courier.income');
            });

            Route::controller('CourierController')->group(function(){
                Route::get('customer/search', 'searchCustomer')->name('search.customer');
            });

            Route::controller('StaffTicketController')->prefix('ticket')->name('ticket.')->group(function () {
                Route::get('/', 'supportTicket')->name('index');
                Route::get('new', 'openSupportTicket')->name('open');
                Route::post('create', 'storeSupportTicket')->name('store');
                Route::get('view/{ticket}', 'viewTicket')->name('view');
                Route::post('reply/{ticket}', 'replyTicket')->name('reply');
                Route::post('close/{ticket}', 'closeTicket')->name('close');
                Route::get('download/{ticket}', 'ticketDownload')->name('download');
            });

            //TRANSACTIONS
            Route::controller('TransactionController')->name('transactions.')->prefix('transactions')->group(function(){
                Route::post('store','transactionStore')->name('store');
                Route::get('/','index')->name('index');
                Route::get('invoice/{id}','invoice')->name('invoice');
                Route::get('details/{id}','details')->name('details');
                Route::get('modifier/{id}','edit')->name('modifier');
                Route::post('updating','update')->name('updating');

            });


            //RDV
            Route::get('create_rdv','rdvController@create')->name('rdv.create');
            Route::post('store_rdv','rdvController@store')->name('rdv.store');
            Route::post('update_rdv','rdvController@update')->name('rdv.update');
            Route::get('list_rdv','rdvController@index')->name('rdv.list');
            Route::get('rdv/search', 'rdvController@rdvSearch')->name('rdv.search');
            Route::get('edit_rdv/{id}','rdvController@edit')->name('rdv.edit');
            Route::get('rdv/details/{id}', 'rdvController@details')->name('rdv.details');
            Route::get('rdv/detail/{id}', 'rdvController@detail')->name('rdv.detail');
            Route::post('rdv/payment','rdvController@rdv_payment')->name('rdv.payment');
            Route::get('rdv/validation/{idmission}','rdvController@rdv_validate')->name('rdv.validation');
            Route::get('rdv/missioncancel/{idmission}','rdvController@rdv_missioncancel')->name('rdv.missioncancel');
             //supprimer rdv
             Route::post('delete_rdv','rdvController@delete_rdv')->name('rdv.delete');

            Route::get('rdv/list','rdvController@getRdv')->name('rdv.liste');
            Route::post('rdv/fetch','rdvController@fetch')->name('rdv.fetch');
            Route::post('rdv/fetchreceiver','rdvController@fetchreceiver')->name('rdv.fetchreceiver');
            Route::get('rdv/depot_bilan','rdvController@bilan_depot')->name('customer.depot_bilan');
            Route::get('rdv/search_depot_bilan','rdvController@search_bilan_depot')->name('customer.search_depot_bilan');
            Route::get('rdv/demandes','rdvController@rdvclient')->name('demande.rdvclient');
            Route::get('/get-client-addresses/{clientId}', 'rdvController@getClientAddresses')->name('client.adresse');

            // NOTIFICATION RDV EN LIGNE
            Route::get('notification/read/{id}','rdvController@notificationRead')->name('notification.read');


            //MISSIONS
            Route::get('mission','MissionController@index')->name('mission.index');
            Route::get('mission/create','MissionController@create')->name('mission.create');
            Route::get('mission/autocomplete','MissionController@autocomplete')->name('mission.autocomplete');
            Route::post('mission/Autocomplete2','MissionCOntroller@fetch')->name('mission.fetch');
            Route::post('mission/store','MissionController@store')->name('mission.store');
            Route::get('mission/assignerdv/{id}','MissionController@createassigne')->name('mission.assigne');
            Route::post('mission/storerdv','MissionController@storerdv')->name('mission.storerdv');
            Route::post('mission/storerdvmulti','MissionController@storerdvmulti')->name('mission.storerdvmulti');
            Route::get('mission/detail/{id}','MissionController@detailmission')->name('mission.detailmission');
            Route::get('mission/validate/{id}','MissionController@validatemission')->name('mission.validatemission');
            Route::get('mission/print/{id}','MissionController@print_mission')->name('mission.print');
            Route::post('mission/end','MissionController@EndMission')->name('mission.end');
            Route::post('mission/get_type','MissionController@getType')->name('mission.getType');
             //ajouter Chauffeur
             Route::post('mission/store_chauffeur','MissionController@store_chauffeur')->name('mission.store_chauffeur');
              //liste des rdv terminés
            Route::get('mission/detailend/{id}','MissionController@detailmissionend')->name('mission.detailmissionend');
             //modifier mission
             Route::get('mission/update/{id}','MissionController@edit_mission')->name('mission.edit');
             Route::post('mission/update_mission','MissionController@update_mission')->name('mission.update_mission');
             Route::post('mission/delete_mission','MissionController@delete_mission')->name('mission.delete_mission');
             Route::post('mission/sendsms','MissionController@sendProgramme')->name('mission.send_sms');
             Route::post('mission/order_list','MissionController@order_list')->name('mission.order_list');
             //reouvrir mission terminée
             Route::post('mission/reopen','MissionController@reOpenMission')->name('mission.reopen');
             Route::get('missionassign/{id}','MissionController@getCreateAssign')->name('mission.createassign');

             
            //TRANSFERT
            Route::post('transfert/store','TransfertController@store')->name('transfert.store');
            Route::post('transfert/rdvstore','TransfertController@rdvstore')->name('transfert.rdvstore');
            Route::get('transfert_list','TransfertController@index')->name('transfert.liste');
            Route::get('transfert/list','TransfertController@getTransferts')->name('transfert.list');
            Route::get('transfert_create','TransfertController@create')->name('transfert.create');
            Route::get('transfert/invoice/{id}', 'TransfertController@invoice')->name('transfert.invoice');
            Route::get('transfert/edit/{id}', 'TransfertController@edit')->name('transfert.edit');
            Route::get('transfert/detail/{id}', 'TransfertController@detail')->name('transfert.detail');
            Route::post('transfert/payment','TransfertController@transfert_payment')->name('transfert.payment');
            Route::get('transfert/receive','TransfertController@getReceive')->name('transfert.receive');
             //modification transfert
             Route::post('transfert_update','TransfertController@update')->name('transfert.update');
             Route::post('transfert_delete','TransfertController@delete')->name('transfert.delete');
             //rechereche transfert
            Route::get('transfert/date/search', 'TransfertController@transfertDateSearch')->name('transfert.date.search');
            Route::get('transfert/search', 'TransfertController@transfertSearch')->name('transfert.search');
            Route::get('transfert/searchreceive', 'TransfertController@transfertSearchReceive')->name('transfert.searchreceive');
            Route::get('transfert/livraison/{id}','TransfertController@livraison')->name('transfert.livraison');
            Route::post('transfert/livraison/validate','TransfertController@livraison_validate')->name('transfert.livraison_validate');
              //bordereau de livraison
              Route::get('transfert/bordereau/{colis_id}/{container_id}','TransfertController@livraison_invoice')->name('transfert.livraison_invoice');
              Route::get('transfert/delivery', 'TransfertController@getReceiveDelivery')->name('transfert.delivery');
              Route::get('transfert/searchdelivery', 'TransfertController@getReceiveDeliverySearch')->name('transfert.searchdelivery');


            //BILAN
            Route::get('transaction/list','BilanController@translist')->name('transaction.list');
            Route::get('transaction/all_list','BilanController@alltranslist')->name('transaction.all_list');
            Route::get('transaction/bilan_jour','BilanController@cash')->name('transaction.bilan_jour');
            Route::get('transaction/depense','BilanController@depense')->name('transaction.depense');
            Route::get('transaction/create_depense','BilanController@create_expense')->name('transaction.create_depense');
            Route::post('transaction/store_depense','BilanController@store_expense')->name('transaction.store_depense');
            Route::get('transaction/date/search', 'BilanController@bilanDateSearch')->name('transaction.date.search');
            Route::get('transaction/edit/{id}','BilanController@edit')->name('transaction.edit');
            Route::get('transaction/date/search/two', 'BilanController@agencebilanDateSearchTwo')->name('transaction.date.searchtwo');

            //modifier paiement
            Route::post('transaction/update','BilanController@update')->name('transaction.update');
            Route::post('transaction/delete','BilanController@delete_paiement')->name('transaction.delete_paiement');
            //transction pour admin
            Route::get('transaction/agencelist','BilanController@agencetranslist')->name('transaction.agencelist');
            Route::post('transaction/store_categorie','BilanController@store_categorie')->name('transaction.store_categorie');
            Route::get('transaction/depense/{id}','BilanController@get_depense')->name('transaction.get_depense');
            Route::post('transaction/update_depense','BilanController@update_depense')->name('transaction.update_depense');
            Route::post('transaction/delete_depense','BilanController@delete_depense')->name('transaction.delete_depense');
            Route::get('transaction/date/agencesearch', 'BilanController@agencebilanDateSearch')->name('transaction.date.agencesearch');
            Route::get('transaction/expense/date/search', 'BilanController@expenseDateSearch')->name('expense.date.search');
            Route::get('transaction/paiement/recu/{id}','BilanController@recupaiement')->name('transaction.recu');



            //CONTAINER
            Route::get('/container','ChargementController@index')->name('container.liste');
            Route::post('/container/store','ChargementController@store_container')->name('container.store');
            Route::get('/container/create','ChargementController@create')->name('container.create');
            Route::get('/container/assigne/{id}','ChargementController@assigne')->name('container.assigne');
            Route::post('/container/store_colis','ChargementController@store_colis')->name('container.store_colis');
            Route::post('container/storecolis','ChargementController@storecolis')->name('container.storecolis');
            Route::post('container/storerdvmulti','ChargementController@storecolismulti')->name('container.storecolismulti');
            Route::get('container/detail/{id}','ChargementController@detailcontainer')->name('container.detailcontainer');
            Route::get('container/coliscancel/{idcolis}/{idcontainer}','ChargementController@colis_containercancel')->name('container.coliscancel');
            Route::post('container/end','ChargementController@EndContainer')->name('container.end');
            
            Route::get('container/search/colis','ChargementController@searchColis')->name('container.search.colis');
            Route::get('container/search/detailcolis','ChargementController@searchDetailColis')->name('container.search.detailcolis');

            Route::get('container/print/charge/{id}','ChargementController@printcharge')->name('container.print.charge');
            Route::get('container/detail_decharge/{id}','ChargementController@detaildecharge')->name('container.detaildecharge');
            Route::post('container/sendsms','ChargementController@smsContainer')->name('container.sms');
            Route::post('container/reopen','ChargementController@reopencontainer')->name('container.reopen');
                    //IMPRIMER CONTENEUR DECHARGE
            Route::get('container/print/decharge/{id}','ChargementController@printdecharge')->name('container.print.decharge');
            Route::get('container/list_colis/{id}','ChargementController@getContainerData')->name('container.listecolis');

            // AFFICHER LISTE COLIS PAYER ET RESTANT A PAYER
            Route::get('container/list_paye/{id}','ChargementController@getContainerPayer')->name('container.listecolispayer');
            Route::get('container/list_restapaye/{id}','ChargementController@getContainerRestaPayer')->name('container.listecolisrestapayer');

            //EXPORT EXCEL
            Route::get('container/export_dejapayer/{id}', 'ChargementController@export_dejapayer')->name('container.export_dejapayer') ;
            Route::get('container/export_restapayer/{id}', 'ChargementController@export_restapayer')->name('container.export_restapayer') ;
            Route::get('bilan/export_liste','BilanController@export_list')->name('bilan.export_list');
             Route::get('client/export_liste','CustomerController@export_list')->name('client.export_list');
             Route::get('encoursparis/export_liste','BilanController@export_encoursparis')->name('encours.paris');
             Route::get('encoursabidjan/export_liste','BilanController@export_encoursabidjan')->name('encours.abidjan');


            // SUIVI 
            Route::get('/suivi','SuiviController@index')->name('suivi.liste');
            Route::get('/suivi/create','SuiviController@create')->name('suivi.create');
            Route::post('/suivi/store','SuiviController@store')->name('suivi.store');
            Route::get('/suivi/edit/{id}','SuiviController@edit')->name('suivi.edit');
            Route::post('/suivi/update','SuiviController@update')->name('suivi.update');

            //DECHARGMENT CONTENEUR
            Route::get('/dechargement','ChargementController@decharge')->name('container.liste_decharge');
            Route::get('dechargement/detail/{id}','ChargementController@detailcontainer')->name('container.detailcontainer');
            Route::post('dechargement/end','ChargementController@DechargeContainer')->name('dechargement.end');
            //CLIENTS
            Route::get('/clients','CustomerController@index')->name('customer.list');
            Route::get('/clients/factures/{id}','CustomerController@facture')->name('customer.factures');
            Route::get('/client/edit/{id}','CustomerController@edit_client')->name('customer.edit');
            Route::post('/client/update/{id}','CustomerController@update')->name('customer.update');
            Route::get('client/search', 'CustomerController@clientSearch')->name('customer.search');
            Route::get('clientdata','CustomerController@getClientData')->name('customerclient.data');

              //VENTES CARTONS ET BARRIQUE
              Route::get('/vente','VenteController@index')->name('vente.list');
              Route::get('/vente/create','VenteController@create')->name('vente.create');
              Route::post('/vente','VenteController@store')->name('vente.store');
              Route::get('/vente/{id}','VenteController@edit')->name('vente.edit');
              Route::post('/vente/update','VenteController@update')->name('vente.update');
              Route::get('/vente/detail/{id}','VenteController@detail')->name('vente.detail');
            //PROSPECT
            Route::get('/prospect','CustomerController@listprospect')->name('prospect.list');
            Route::get('/prospectcreate','CustomerController@createprospect')->name('prospect.create');
            Route::get('/prospect/{id}','CustomerController@editprospect')->name('prospect.editprospect');
            Route::post('/prospectstore','CustomerController@prospectstore')->name('prospect.store');
            Route::post('/prospectstatus','CustomerController@prospectstatus')->name('prospect.status');
            Route::post('/prospectupdate/{id}','CustomerController@updateprospect')->name('prospect.update');


            // SMS RAPPORT
            Route::get('/smsrapport','SmsController@index')->name('sms.rapport');
            // ENCOURS
            Route::get('encoursabidjan','BilanController@encoursAbidjan')->name('bilan.encoursabidjan');
            Route::get('encoursparis','BilanController@encoursParis')->name('bilan.encoursparis');

            Route::get('encours/date/search/abidjan','BilanController@encoursDateSearchAbidjan')->name('bilan.encours.searchabidjan');
            Route::get('encours/date/search/paris','BilanController@encoursDateSearchParis')->name('bilan.encours.searchparis');
            
             // ENTREPOTS colis disponible 
             Route::get('entrepot','TransfertController@entrepotlist')->name('entrepot.list');
             
              // AFFICHER LA LISTE DES COLIS NON PAYE
             Route::get('colis_nonpaye','TransfertController@colisNonPaye')->name('colis.nonpayes');

        });
    });
});
