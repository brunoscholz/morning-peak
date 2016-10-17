<?php

use yii\helpers\Html;

?>

<!-- Company box -->
<div class="box box-solid bg-light-blue-gradient">
  <div class="box-header">
    <!-- tools box -->
    <div class="pull-right box-tools">
      <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
    </div><!-- /. tools -->

    <i class="fa fa-building"></i>
    <?= Html::a(
        '<h3 class="box-title">'.$data->name.'</h3>',
        ['profile', 'id' => $data->sellerId],
        ['class' => '']
    ) ?>

  </div>
  <div class="box-body">
    <div id="world-map" style="height: 250px; width: 100%;">
    	<p><?php echo $data->email; ?></p>
    	<p><?php echo $data->website; ?></p>
    	<p><?php echo $data->about; ?></p>
    </div>
  </div><!-- /.box-body-->
  <div class="box-footer no-border">
    <div class="row">
      <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
        <div id="sparkline-1"></div>
        <div class="knob-label">Editar</div>
      </div><!-- ./col -->
      <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
        <div id="sparkline-2"></div>
        <div class="knob-label">Ver</div>
      </div><!-- ./col -->
      <div class="col-xs-4 text-center">
        <div id="sparkline-3"></div>
        <div class="knob-label">--</div>
      </div><!-- ./col -->
    </div><!-- /.row -->
  </div>
</div>
<!-- /.box -->