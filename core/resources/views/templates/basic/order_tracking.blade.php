@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $orderTracking = getContent('order_tracking.content', true);
    @endphp
     <section class="track-section pt-120 pb-120">
        <div class="container">
            <div class="section__header section__header__center">
                <span class="section__cate">
                    {{__(@$orderTracking->data_values->title)}}
                </span>
                <h3 class="section__title"> {{__(@$orderTracking->data_values->heading)}}</h3>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9 col-xl-6">
                    <form action="{{route('order.tracking')}}" method="GET" class="order-track-form mb-4 mb-md-5">
                        @csrf
                        @method("GET")
                        <div class="order-track-form-group">
                            <input type="text" name="order_number" placeholder="@lang('Entrez votre reference')" value="{{@$orderNumber->reference_souche}}">
                            <button type="submit">@lang('Suivre Maintenant')</button>
                        </div>
                    </form>
                </div>
            </div>
        
            @if($orderNumber)
            <div class="ustify-content-center">
            <h5 class="track__title j"> Reference : {{$orderNumber->reference_souche}} <br>Nombre : {{$orderNumber->transfertDetail->count()}} colis <br> enregistré le : {{date('d-m-Y',strtotime($orderNumber->created_at))}}</h5>
            </div>
                <div class="track--wrapper">
                    <div class="track__item  done ">
                        <div class="track__thumb">
                            <i class="las la-briefcase"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Picked')</h5>
                        </div>
                    </div>
                    <div class="track__item  done ">
                        <div class="track__thumb">
                            <i class="las la-building"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Assort')</h5>
                        </div>
                    </div>
                    @if($orderNumber->paymentInfo->status == 2)
                    <div class="track__item  done">
                        <div class="track__thumb">
                            <i class="las la-money-bill"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Completed')</h5>
                        </div>
                    </div>
                    @else
                    <div class="track__item ">
                        <div class="track__thumb">
                            <i class="las la-money-bill"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">Non @lang('Completed') <br> totalement</h5>
                        </div>
                    </div>

                    @endif
                    
                    <div class="track__item @if($orderNumber->status == 1 || $orderNumber->paymentInfo->status == 2) done @endif">
                        <div class="track__thumb">
                            <i class="las la-check-circle"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Envoi En Cours')</h5>
                        </div>
                    </div>
                    
                </div>
            @endif
            <div class="clear"></div>
            @if(isset($orderConteneur) && !empty($orderConteneur))
            <div class="track--wrapper">

            @forelse($orderConteneur as $cont)

                  <div class="track__item  done ">
                        <div class="track__thumb">
                            <i class="las la-ship"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Loaded in container')<br> le {{date('d-m-Y',strtotime($cont->conteneur->date))}}</h5>
                        </div>
                    </div>
                    
                    <div class="track__item done ">
                        <div class="track__thumb">
                            <i class="las la-box"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">{{$cont->nb_colis}} colis chargé  </h5>
                        </div>
                    </div>
                    @if($cont->conteneur->status !=2)
                    <div class="track__item ">
                        <div class="track__thumb">
                            <i class="las la-anchor"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">Arrivée estimée <br>le {{date('d-m-Y',strtotime($cont->conteneur->date_arrivee))}}</h5>
                        </div>
                    </div>
                    @else
                    <div class="track__item done ">
                        <div class="track__thumb">
                            <i class="las la-anchor"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">Colis Disponible <br> Appeler au (+225) 0141652222 / 0141652323 </h5>
                        </div>
                    </div>
                    @endif
                    @if($cont->date_livraison == null)
                    <div class="track__item ">
                        <div class="track__thumb">
                            <i class="las la-truck"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">Non @lang('Delivered')</h5>
                        </div>
                    </div>
                    @else
                    <div class="track__item done">
                        <div class="track__thumb">
                            <i class="las la-truck"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Delivered') <br>le {{date('d-m-Y',strtotime($cont->date_livraison))}}</h5>
                        </div>
                    </div>
                    @endif
                    @empty

                    @endforelse
                    </div>

            @endif
        
    </section>
@endsection
