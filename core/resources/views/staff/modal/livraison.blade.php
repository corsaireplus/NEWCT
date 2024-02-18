

            <form action="{{route('staff.transactions.livraison_validate')}}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <input type="hidden" name="colis_id">
                    <input type="hidden" name="container_id">

                    <p>@lang('Entrer les Informations de livraison')</p>
                    <div class="form-group">
                        <div class="row">
                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control form-control-lg" name="nom" id="nom" placeholder="Nom & Prenom" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control form-control-lg" name="telephone" id="telephone" placeholder="Telephone" required>
                        </div>
                            </div>
                      <div class="row">  
                           <div class="form-group col-lg-12">
                            <input type="numeric" class="form-control form-control-lg" name="piece_id"  id="piece_id" placeholder="Nature & Numero piece" required>
                        </div>
                      </div>
                        <div class="row">
                       <div class="form-group col-lg-12">
                            <textarea class="form-control form-control-lg" name="description"  id="description" placeholder="description" required></textarea>
                        </div>
                    </div>
                    </div>
                   <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Enregistrer')</button>
             </div>
            </form>
 