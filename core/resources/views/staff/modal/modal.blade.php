
<div class="modal fade" id="depenseBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Ajouter Depense')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
            </div>

            <form action="{{route('staff.transaction.store_depense')}}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <input type="hidden" name="mission">
                    <input type="hidden" name="cat_id" value="10">
                    <p>@lang('Entrez Information Depense')</p>
                    <div class="form-group">
                        

                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control" name="montant" id="montant" placeholder="Montant Depense">
                        </div>
                      
                        
                            <label>@lang('Entrer Description')</label>
                            <textarea name="description" id="description" rows="4" class="form-control form-control-lg" placeholder="@lang('Entrer Message')">{{old('message')}}</textarea>

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--primary">@lang('Enregistrer')</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('SUPPRIMER PROGRAMME')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="{{route('staff.mission.delete_mission')}}" method="POST">
                    @csrf
                    <input type="hidden" name="idmission"id="idmission" >
                    <div class="modal-body">
                    <p>@lang('Êtes vous sûr de vouloir Supprimer ce programme ?')</p>
                </div>

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-fw fa-trash"></i>@lang('Supprimer')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Terminer Programme')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.mission.end')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Etes Vous sûr de terminer le programme?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirmer')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ropenBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Rouvrir Programme')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.mission.reopen')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Etes Vous sûr de rouvrir le programme?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirmer')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="envoiSms" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('ENVOYER SMS AUX CLIENTS')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>

            <form action="{{route('staff.mission.send_sms')}}" method="POST">
                @csrf
                <input type="hidden" name="idmission" id="idmission">
                <input type="hidden" name="contact" id="contact">

                <div class="modal-body">
                      <div class="form-group">
                        
                            <label>@lang('Entrer Message')</label>
                            <textarea name="message" id="message" rows="4" class="form-control form-control-lg" placeholder="@lang('Entrer Message')">{{old('message')}}</textarea>
                        
                        </div>

               <p>NB: SMS non valable les dimanches et jour ferié</p>
                    <p>@lang('Êtes vous sûr de vouloir envoyer les sms?')</p>
                </div>


                <div class="modal-footer">
                <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--primary">@lang('Envoyer')</button>
                </div>
            </form>
        </div>
    </div>
</div>
