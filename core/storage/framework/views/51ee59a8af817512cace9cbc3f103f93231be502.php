<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Conteneur N° <?php echo e($mission->numero); ?></title>
    <style type="text/css" >
    .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 11px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 5px;
  
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
  border: 1px solid black;
}

table th,
table td {
  text-align: center;
  border: 1px solid black;
}

table th {
  padding: 3px 10px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 5px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    </style>
  </head>
  <body onload="window.print();">
    <header class="clearfix">
      <div id="logo">
       
      </div>
      <h1>LISTE DES COLIS DU CONTENEUR <?php echo e($mission->numero); ?> du <?php echo e(date('d-m-Y',strtotime($mission->date))); ?> </h1>
      <div id="company" class="clearfix">
        <div>Challenges Groupe</div>
        <div>,<br /></div>
        <!-- <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div> -->
      </div>
      <div id="project">
        <div><span>DATE : </span> <?php echo e(date('d-m-Y',strtotime($mission->date))); ?></div>
        <div><span>CONTENEUR N°</span> <?php echo e($mission->numero); ?> </div>
        <div><span>ARMATEUR</span> <?php echo e($mission->armateur); ?> </div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <!-- <th>#</th>            -->
            <th class="desc">REFERENCE</th>
            <th>NB COLIS</th>
            <th>CHARGE</th>
            <th>DESCRIPTION COLIS</th>
            <th>DESTINATAIRE</th> 
            <th>CONTACT</th>
            <th>RESTE</th>
           
          </tr>
        </thead>
        <tbody>
          <?php
          $totalpaye = 0;
          
          ?>
            <?php $__empty_1 = true; $__currentLoopData = $rdv_chauf->sortBy('transaction.reference_souche'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $miss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php if($miss->transaction): ?>                             
          <tr>
              <!-- <td><?php echo e(++$key); ?></td> -->
              <td><?php echo e($miss->transaction->reftrans); ?></td>
              <td><?php echo e($miss->transaction->transfertDetail->count()); ?></td>
              <td><?php echo e($miss->nb_colis); ?></td>
            <td class="desc"><?php $__currentLoopData = $miss->transaction->courierDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       
                                      <?php echo e($detail->type->name); ?><?php if($miss->transaction->transfertDetail->count() > 1): ?>- <?php endif; ?>
                                     
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                                       <td><?php echo e($miss->transaction->receiver->nom); ?></td>
                                       <td><?php echo e($miss->transaction->receiver->contact); ?></td>
                                       
                                      <td><?php echo e(getAmount($miss->transaction->paymentInfo->receiver_amount - $miss->paye)); ?></td>

            
           
          </tr>
          <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <?php endif; ?>
          
        </tbody>
      </table>
      <div id="notices">
        <div>NOTE:</div>
        <div class="notice"></div>
      </div>
    </main>
    <footer>
     
    </footer>
  </body>
</html>



<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/container/printcharge.blade.php ENDPATH**/ ?>