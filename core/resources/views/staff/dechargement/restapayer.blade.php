@extends('staff.layouts.app')
@section('panel')


 <div class="row mt-30">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div id="impri" class="table-responsive--sm custom-data-table table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    
                                    <th>@lang('Reference')</th>
                                    <th>@lang('Nb Colis')</th>
                                    <th>@lang('Chargé')</th>
                                    <th>@lang('Destinataire')</th>
                                    <th>@lang('Contact')</th>
                                    <th>@lang('Frais')</th>
                                    <th>@lang('Reste a Payer')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($rdv_chauf as $rdv)
                            @if($rdv->colis && $rdv->colis->paymentInfo->status != 2)
                                <tr>
                               
                                   
                                    <td data-label="@lang('Reference')">
                                    @if($rdv->colis->paymentInfo->status == 0 )
                                        <span class="badge badge--danger"><a href="{{route('staff.transfert.detail', encrypt($rdv->colis->id))}}" title="" >{{$rdv->colis->reference_souche}}</a></span>
                                        @elseif($rdv->colis->paymentInfo->status == 1 )
                                        <span class="badge badge--warning"><a href="{{route('staff.transfert.detail', encrypt($rdv->colis->id))}}" title="" >{{$rdv->colis->reference_souche}}</a></span>
                                        @elseif($rdv->colis->paymentInfo->status == 2)
                                        <span class="badge badge--success"><a href="{{route('staff.transfert.detail', encrypt($rdv->colis->id))}}" title="" >{{$rdv->colis->reference_souche}}</a></span>
                                        @endif

                                    </td>

                                    <td data-label="@lang('Nb colis')">
                                        <span></span>
                                    </td>
                                    <td data-label="@lang('Chargé')">
                                        
                                        <span>{{$rdv->nb_colis}}</span>
                                        
                                    </td>
                                    <td data-label="@lang('Client')">
                                    {{$rdv->colis->receiver->nom}}
                                      
                                    </td>

                                    <td data-label="@lang('Contact')">
                                    {{$rdv->colis->receiver->contact}}
                                    </td>
                                    <td>{{getAmount($rdv->colis->paymentInfo->receiver_amount)}} {{auth()->user()->branch->currencie}}</td>
                                    <td>{{getAmount($rdv->colis->paymentInfo->receiver_amount - $rdv->paye)}} {{auth()->user()->branch->currencie}}</td>

                                    <td data-label="@lang('Status Livraison')"> 
                                    @if($rdv->colis->container_id == NULL || empty($rdv->colis->container_id)  )
                                    <span class="badge badge--danger">@lang('Non Livré')</span>
                                    @elseif($rdv->colis->container_id == 1 )
                                    <span class="badge badge--warning">@lang('Livraison Partiel')</span>
                                    @elseif($rdv->colis->paymentInfo->status == 2)
                                    <span class="badge badge--success">@lang('Payé')</span>
                                    @endif
                                </td>
                                    @if($rdv->status <= 2 )
                                   
                                    @else 
                                    
                                    <a href="{{route('staff.rdv.details', encrypt($rdv->idrdv))}}" title="" class="icon-btn btn--info ml-1 delivery" data-code="{{$rdv->idrdv}}"> Detail</a>
                                    <span class="badge badge-pill bg--success">@lang('Terminé')</span> 
                                    @endif
                                    
                                    </td>
                                </tr>
                               @endif
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                          
                            @endforelse

                            </tbody>
                            <tfoot>
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total:</td>
                                <td id="total-frais"></td>
                                <td></td>
                                <!-- autres cellules pour les totaux des autres colonnes -->
                              </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                {{ paginateLinks($rdv_chauf) }}
                </div>
            </div>
        </div>
     </div>
</div>
    @endsection
@push('breadcrumb-plugins')
<!-- <button  class="btn btn-primary m-1"><i class="fa fa-download"></i>@lang('Print')</button>-->
@if(auth()->user()->branch->country == 'FRA')
<a href="{{route('staff.container.print.charge',encrypt($mission->idcontainer))}}" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> @lang('Imprimer')</a> 
<a href="{{route('staff.container.liste')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
@else
<a href="{{route('staff.container.export_restapayer',encrypt($mission->idcontainer))}}" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> @lang('Imprimer')</a> 
<a href="{{ url()->previous() }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>

@endif
@endpush
@push('script')
<script>
    "use strict";
    $('.printInvoice').click(function () { 
        var divContents = document.getElementById("impri").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
            
    });

    $('.payment').on('click', function () {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        modal.modal('show');
    });
</script>
<script type="text/javascript" language="javascript">
    function printDiv() {
            var divContents = document.getElementById("impri").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
</script>
<script type="text/javascript" langage="javascript">
    // Fonction pour calculer le total d'une colonne
function calculerTotalColonne(indexColonne) {
  var total = 0;
  // Sélectionner toutes les lignes du tableau
  var lignes = document.querySelectorAll('table tr');

  // Parcourir chaque ligne (sauf l'en-tête)
  for(var i = 1; i < lignes.length; i++) {
    // Récupérer les cellules de la ligne
    var cellules = lignes[i].cells;
    // Récupérer la valeur numérique de la colonne désirée
    var valeur = parseFloat(cellules[indexColonne].textContent.replace(/[^0-9.-]+/g,""));
    // Ajouter cette valeur au total, s'assurer que c'est un nombre
    if(!isNaN(valeur)) {
      total += valeur;
    }
  }
  return total;
}

// Exemple d'utilisation de la fonction pour la colonne des frais (supposons que c'est l'index 4)
var totalFrais = calculerTotalColonne(6);
console.log('Total des frais: ', totalFrais);

// Afficher le total sur la page web, par exemple dans un élément avec l'id 'total-frais'
document.getElementById('total-frais').textContent = totalFrais + ' FCFA';

</script>
@endpush



