<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Mission <?php echo e($mission->idmission); ?></title>
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
      <h1>PROGRAMME DU <?php echo e(date('d-m-Y', strtotime($mission->date))); ?></h1>
      <div id="company" class="clearfix">
        <div>Challenges Groupe</div>
        <div>,<br /></div>
        <!-- <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div> -->
      </div>
      <div id="project">
        <div><span>CHAUFFEUR</span> <?php echo e($mission->chauffeur->fullname); ?> </div>
        <div><span>CONTACT</span> <?php echo e($mission->chauffeur->mobile); ?> </div>
        <div><span>CHARGEUR</span> <?php echo e($mission->chargeur->fullname); ?> </div>
        <div><span>CONTACT</span> <?php echo e($mission->contact); ?> </div>
        <div><span>CAMION</span> <?php echo e($mission->camion); ?> </div>

      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
           
            <th class="desc">DESCRIPTION</th>
            <th>ADRESSE</th>
            <th>CODE POSTAL</th>
            <th>CONTACT</th>
            <th>OBSERVATION</th>
           
          </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $rdv_chauf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td class="desc"><?php $__currentLoopData = $miss->rdvDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($detail->rdv_type_id == 2): ?>
                                      DEPOT <?php echo e($detail->qty); ?> <?php echo e($detail->type->name); ?> -
                                      <?php elseif($detail->rdv_type_id == 1 ): ?>
                                      RECUP <?php echo e($detail->qty); ?> <?php echo e($detail->type->name); ?> -
                                      <?php endif; ?>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                                       <?php if($miss->adresse): ?>
            <td class="unit"><?php echo e($miss->adresse->adresse); ?></td>
            <?php else: ?>
            <td>N/A</td>
            <?php endif; ?>
            <?php if($miss->adresse): ?>
            <td class="qty"><?php echo e($miss->adresse->code_postal); ?></td>
            <?php else: ?>
            <td>N/A</td>
            <?php endif; ?>
            <td class="total"><?php echo e($miss->client->contact); ?></td>
            <?php if($miss->observation !== NULL): ?>
            <td class="total"><?php echo e($miss->observation); ?></td>
            <?php else: ?>
            <td class="total"></td>
            <?php endif; ?>
           
          </tr>
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
</html><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/print_mission_list.blade.php ENDPATH**/ ?>