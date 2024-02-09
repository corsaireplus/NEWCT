<form action="{{route('staff.mission.send_sms')}}" method="POST">
                @csrf
                <input type="hidden" name="idmission" id="idmission" value="{{$idmission}}">
                <input type="hidden" name="contact" id="contact" value={{$contact}}>

                <div class="modal-body">
                      <div class="form-group">
                        
                            <label>@lang('Entrer Message')</label>
                            <textarea name="message" id="message" rows="4" class="form-control form-control-lg" placeholder="@lang('Entrer Message')">{{old('message')}}</textarea>
                        
                        </div>

               <p>NB: SMS non valable les dimanches et jour ferié</p>
                    <p>@lang('Êtes vous sûr de vouloir envoyer les sms?')</p>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Envoyer Sms')</button>
                </div>
    <form>