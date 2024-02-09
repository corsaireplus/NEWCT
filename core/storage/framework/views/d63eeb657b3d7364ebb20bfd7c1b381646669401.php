<?php $__env->startSection('content'); ?>

<section class="track-section pt-120 pb-120">
        <div class="container">
            <div class="section__header">
                    <span class="section__cate">Akwaba Chez Challenge Transit</span>
                    <h3 class="section__title">Specialiste des envois express</h3>
                    <!--p>
                        veuillez contactez-nous au 0179751616
                    </p-->
                </div>
            <div class="">
                            <div class="about__item">
                               
                                   <div class="about__item-icon">
                                      <i class="las la-business-time"></i>                                  
                                      </div>
                                   <div class="about__item-content">
                                       <a href="<?php echo e(route('rdvclient')); ?>"> <h6 class="about__item-content-title">Prendre Rendez-Vous</h6></a>
                                      
                                   </div>
                                  
                              </div>
                                                         <div class="about__item">
                                   <div class="about__item-icon">
                                      <i class="las la-search-location"></i>                                   </div>
                                   <div class="about__item-content">
                                       <a href="<?php echo e(route('order.tracking')); ?>"><h6 class="about__item-content-title">Suivre Son Colis</h6></a>
                                      
                                   </div>
                              </div>
                                                         <div class="about__item">
                                   <div class="about__item-icon">
                                      <i class="las la-calendar-day"></i>                                  </div>
                                   <div class="about__item-content">
                                       <a href="<?php echo e(route('home.departs')); ?>"><h6 class="about__item-content-title">Prochains Départs</h6></a>
                                       <!--p>
                                          L'acheminement de vos colis de l'Europe vers Abidjan dans les délais promis
                                       </p-->
                                   </div>
                              </div>
                                                   </div>
            </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/akwaba.blade.php ENDPATH**/ ?>