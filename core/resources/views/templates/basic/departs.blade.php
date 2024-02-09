@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="track-section pt-120 pb-120">
        <div class="container">
            <div class="section__header">
                    <span class="section__cate">Challenge Transit</span>
                    <!--h3 class="section__title">Nos Prochains départs</h3>
                    <p>
                        veuillez contactez-nous au 0179751616
                    </p-->
                </div>
                <div class="col-lg-12">
                <div class="faqs-thumb">
               <img src="{{getImage('assets/images/frontend/departs/ct_departs_janvier.jpeg','departs')}}"  alt="@lang('contact')">                </div>
              </div>
              
               
            
            </div>
    </section>
@endsection