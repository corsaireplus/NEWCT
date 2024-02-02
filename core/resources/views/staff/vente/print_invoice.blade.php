<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>reçu_#{{$courierInfo->reference}} - Challenges-groupe.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body onload="window.print();">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
   <div class="col-md-12">
      <div class="invoice">
         <!-- begin invoice-company -->
         <div class="invoice-company text-inverse f-w-600">CHALLENGE TRANSIT - RECU PAIEMENT</div>
         <!-- end invoice-company -->
         <!-- begin invoice-header -->
         <div class="invoice-header">
            <div class="invoice-from">
            <small>De</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse">CHALLENGES TRANSIT.</strong><br>
                  Tél: (123) 456-7890<br>
               </address>
               @php echo $code @endphp
            </div>
            <div class="invoice-to">
               <small>A</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse">{{$courierInfo->client->nom}}</strong><br>
                  Tél: {{$courierInfo->client->contact}}<br>
                 
               </address>
            </div>
            <div class="invoice-date">
               <small>Reçu Paiement</small>
               <div class="date text-inverse m-t-5">Date : {{date('d-m-Y', strtotime($courierInfo->date))}}</div>
               <div class="invoice-detail">
                  #{{$courierInfo->reference}}<br>

                  Agent : {{$courierInfo->senderStaff->fullname}}
               </div>
            </div>
         </div>
         <!-- end invoice-header -->
         <!-- begin invoice-content -->
         <div class="invoice-content">
            <!-- begin table-responsive -->
            <div class="table-responsive">
               <table class="table table-invoice">
                  <thead>
                     <tr>
                        <th>DESCRIPTION</th>
                        <th class="text-center" width="10%">QTE</th>
                        <th class="text-center" width="10%">P.UNITAIRE</th>
                        <th class="text-right" width="20%">SOUS-TOTAL</th>
                     </tr>
                  </thead>
                  <tbody>
                  @php
                                    $total = 0;
                                    @endphp
                    @foreach($courierProductInfos as $detail)
                     <tr>
                        <td>
                           <span class="text-inverse">{{$detail->type->name}}</span><br>
                           <small></small>
                        </td>
                        <td class="text-center">{{$detail->qty}}</td>
                        <td class="text-center">{{getAmount($detail->type->price)}}</td>
                        <td class="text-right">{{$detail->fee}} €</td>
                     </tr>
                     @php
                                    $total += $detail->fee;
                                    @endphp
                     @endforeach
                    
                  </tbody>
               </table>
            </div>
            <!-- end table-responsive -->
            <!-- begin invoice-price -->
            <div class="invoice-price">
               <div class="invoice-price-left">
                  <div class="invoice-price-row">
                     <!-- <div class="sub-price">
                        <small>SOUS-TOTAL</small>
                        <span class="text-inverse"> €</span>
                     </div> -->
                     <div class="sub-price">
                        <!-- <i class="fa fa-plus text-muted"></i> -->
                     </div>
                     <!-- <div class="sub-price">
                        <small>PAYPAL FEE (5.4%)</small>
                        <span class="text-inverse">$108.00</span>
                     </div> -->
                  </div>
               </div>
               <div class="invoice-price-right">
                  <small>TOTAL</small> <span class="f-w-600">{{getAmount($total)}} €</span>
               </div>
            </div>
            <!-- end invoice-price -->
         </div>
         <!-- end invoice-content -->
         <!-- begin invoice-note -->
         <div class="invoice-note">
            * Make all cheques payable to [Your Company Name]<br>
            * Payment is due within 30 days<br>
            * If you have any questions concerning this invoice, contact  [Name, Phone Number, Email]
         </div>
         <!-- end invoice-note -->
         <!-- begin invoice-footer -->
         <div class="invoice-footer">
            <p class="text-center m-b-5 f-w-600">
                MERCI DE VOTRE CONFIANCE            </p>
            <p class="text-center">
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> challenges-groupe.com</span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> T:016-18192302</span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i>info@challenges-groupe.com</span>
            </p>
         </div>
         <!-- end invoice-footer -->
      </div>
   </div>
</div>

<style type="text/css">
body{
    margin-top:20px;
    background:#eee;
}

.invoice {
    background: #fff;
    padding: 20px
}

.invoice-company {
    font-size: 20px
}

.invoice-header {
    margin: 0 -20px;
    background: #f0f3f4;
    padding: 20px
}

.invoice-date,
.invoice-from,
.invoice-to {
    display: table-cell;
    width: 1%
}

.invoice-from,
.invoice-to {
    padding-right: 20px
}

.invoice-date .date,
.invoice-from strong,
.invoice-to strong {
    font-size: 16px;
    font-weight: 600
}

.invoice-date {
    text-align: right;
    padding-left: 20px
}

.invoice-price {
    background: #f0f3f4;
    display: table;
    width: 100%
}

.invoice-price .invoice-price-left,
.invoice-price .invoice-price-right {
    display: table-cell;
    padding: 20px;
    font-size: 20px;
    font-weight: 600;
    width: 75%;
    position: relative;
    vertical-align: middle
}

.invoice-price .invoice-price-left .sub-price {
    display: table-cell;
    vertical-align: middle;
    padding: 0 20px
}

.invoice-price small {
    font-size: 12px;
    font-weight: 400;
    display: block
}

.invoice-price .invoice-price-row {
    display: table;
    float: left
}

.invoice-price .invoice-price-right {
    width: 25%;
    background: #2d353c;
    color: #fff;
    font-size: 28px;
    text-align: right;
    vertical-align: bottom;
    font-weight: 300
}

.invoice-price .invoice-price-right small {
    display: block;
    opacity: .6;
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 12px
}

.invoice-footer {
    border-top: 1px solid #ddd;
    padding-top: 10px;
    font-size: 10px
}

.invoice-note {
    color: #999;
    margin-top: 30px;
    font-size: 85%
}

.invoice>div:not(.invoice-footer) {
    margin-bottom: 20px
}

.btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
    color: #2d353c;
    background: #fff;
    border-color: #d9dfe3;
}
</style>

<script type="text/javascript">

</script>
</body>
</html>