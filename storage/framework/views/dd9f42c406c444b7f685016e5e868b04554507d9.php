
<?php if($xml): ?>

  <?php  
    $obj = json_decode($xml);
    $pts = array_search('TS', array_column($obj, 'tipo'));
    $ptw = array_search('TW', array_column($obj, 'tipo'));
    $ptd = array_search('TD', array_column($obj, 'tipo'));

    $cts = $obj[$pts]->data_0;
    $ctw = $obj[$ptw]->data_0;
    $ctd = $obj[$ptd]->data_0;

    $tts = $obj[$pts]->data_1;
    $ttw = $obj[$ptw]->data_1;
    $ttd = $obj[$ptd]->data_1;


   ?>  



<div class="be-content xml_content">
  <div class="main-content container-fluid">
    <div class="row">

      <?php if($cts>0): ?>
      <div class="colxml col-xs-12 col-sm-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div role="alert" class="alert alert-success alert-icon alert-icon-border alert-dismissible">
              <div class="icon"><span class="mdi mdi-check"></span></div>
              <div class="message">

                  <button type="button"  aria-label="Close" class="close xmlclose">
                      <span aria-hidden="true" class="mdi mdi-close"></span>
                  </button>

                  <button type="button"  aria-label="Ocultar" class="close xmlocultarmostrar">
                      <span aria-hidden="true" class="mdi mdi-chevron-right mdi-hc-2x"></span>
                      <span aria-hidden="true" class="mdi mdi-chevron-down mdi-hc-2x"></span>
                  </button>

                  <strong><?php echo e($cts); ?> </strong> <?php echo e($tts); ?>

              </div>
            </div>


            <div class = 'xmlscrollpanel'>

              <div class="panel panel-border scrollpanel no4 none">

                <div class="panel-body">
                    <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($item->tipo == 'S'): ?>
                        <p class="text-muted"> 
                          <strong><?php echo e($item->data_0); ?> :</strong>
                          <?php echo e($item->data_1); ?>

                        </p>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>

            </div>




          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php if($ctw>0): ?>
      <div class="colxml col-xs-12 col-sm-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
              <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
              <div class="message">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close xmlclose"><span aria-hidden="true" class="mdi mdi-close"></span></button>

                <button type="button"  aria-label="Ocultar" class="close xmlocultarmostrar">
                    <span aria-hidden="true" class="mdi mdi-chevron-right mdi-hc-2x"></span>
                    <span aria-hidden="true" class="mdi mdi-chevron-down mdi-hc-2x"></span>
                </button>                      

                <strong><?php echo e($ctw); ?> </strong> <?php echo e($ttw); ?>

              </div>
            </div>

            <div class = 'xmlscrollpanel'>

              <div class="panel panel-border scrollpanel no4 none">

                <div class="panel-body">
                    <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($item->tipo == 'W'): ?>
                        <p class="text-muted"> 
                          <strong><?php echo e($item->data_0); ?> :</strong>
                          <?php echo e($item->data_1); ?>

                        </p>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </div>
              </div>

            </div>


          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php if($ctd>0): ?>
      <div class="colxml col-xs-12 col-sm-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div role="alert" class="alert alert-danger alert-icon alert-icon-border alert-dismissible">
              <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
              <div class="message">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close xmlclose"><span aria-hidden="true" class="mdi mdi-close"></span></button>

                <button type="button"  aria-label="Ocultar" class="close xmlocultarmostrar">
                    <span aria-hidden="true" class="mdi mdi-chevron-right mdi-hc-2x"></span>
                    <span aria-hidden="true" class="mdi mdi-chevron-down mdi-hc-2x"></span>
                </button>  

                <strong><?php echo e($ctd); ?> </strong> <?php echo e($ttd); ?>

              </div>
            </div>

            <div class = 'xmlscrollpanel'>

              <div class="panel panel-border scrollpanel no4 none">

                <div class="panel-body">
                    <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($item->tipo == 'D'): ?>
                        <p class="text-muted"> 
                          <strong><?php echo e($item->data_0); ?> :</strong>
                          <?php echo e($item->data_1); ?>

                        </p>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
      <?php endif; ?>

    </div>
  </div>
</div>
<?php endif; ?>
