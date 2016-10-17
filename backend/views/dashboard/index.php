<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?= Html::encode($this->title) ?>
    <small>Control panel</small>
  </h1>
  <?php $this->params['breadcrumbs'][] = $this->title; ?>
</section>

<?= Html::img('@web/img/visa.png', ['alt' => 'My logo', 'width'=>'100']) ?>


<p>
    <?= Html::a('Criar Prestadora', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<!-- Main content -->
<section class="content">

  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>150</h3>
          <p>New Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>
          <p>Bounce Rate</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>44</h3>
          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>65</h3>
          <p>Unique Visitors</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->

  </div><!-- /.row -->  

  <!-- Main row -->
  <div class="row">

  	<!-- Left col -->
    <section class="col-lg-4 connectedSortable">
    	<?= $this->render('_companyBox', [
        	'data' => $dataProvider,
    	]) ?>
    </section>

    <!-- Middle col -->
    <section class="col-lg-4 connectedSortable">
  	  <!-- Company box -->
      <div class="box box-solid bg-green-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
          </div><!-- /. tools -->

          <i class="fa fa-building"></i>
          <h3 class="box-title">
            Company #2
          </h3>
        </div>
        <div class="box-body">
          <div id="world-map" style="height: 250px; width: 100%;"></div>
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
    </section>

    <!-- Right col -->
    <section class="col-lg-4 connectedSortable">
  	  <!-- Company box -->
      <div class="box box-solid bg-teal-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
          </div><!-- /. tools -->

          <i class="fa fa-building"></i>
          <h3 class="box-title">
            Company #3
          </h3>
        </div>
        <div class="box-body">
          <div id="world-map" style="height: 250px; width: 100%;"></div>
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
    </section>

  </div><!-- /.row (main row) -->

  <div class="row">
    
    <!-- Left col -->
    <section class="col-lg-4 connectedSortable">
      <!-- DIRECT CHAT -->
      <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Direct Chat</h3>
          <div class="box-tools pull-right">
            <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <!-- Conversations are loaded here -->
          <div class="direct-chat-messages">
            <!-- Message. Default to the left -->
            <div class="direct-chat-msg">
              <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left">Alexander Pierce</span>
                <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
              </div><!-- /.direct-chat-info -->
              <img class="direct-chat-img" src="<?= $directoryAsset ?>/img/user1-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                Is this template really for free? That's unbelievable!
              </div><!-- /.direct-chat-text -->
            </div><!-- /.direct-chat-msg -->

            <!-- Message to the right -->
            <div class="direct-chat-msg right">
              <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-right">Sarah Bullock</span>
                <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
              </div><!-- /.direct-chat-info -->
              <img class="direct-chat-img" src="<?= $directoryAsset ?>/img/user3-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                You better believe it!
              </div><!-- /.direct-chat-text -->
            </div><!-- /.direct-chat-msg -->

            <!-- Message. Default to the left -->
            <div class="direct-chat-msg">
              <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left">Alexander Pierce</span>
                <span class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>
              </div><!-- /.direct-chat-info -->
              <img class="direct-chat-img" src="<?= $directoryAsset ?>/img/user1-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                Working with AdminLTE on a great new app! Wanna join?
              </div><!-- /.direct-chat-text -->
            </div><!-- /.direct-chat-msg -->

            <!-- Message to the right -->
            <div class="direct-chat-msg right">
              <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-right">Sarah Bullock</span>
                <span class="direct-chat-timestamp pull-left">23 Jan 6:10 pm</span>
              </div><!-- /.direct-chat-info -->
              <img class="direct-chat-img" src="<?= $directoryAsset ?>/img/user3-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                I would love to.
              </div><!-- /.direct-chat-text -->
            </div><!-- /.direct-chat-msg -->
          </div><!--/.direct-chat-messages-->

          <!-- Contacts are loaded here -->
          <div class="direct-chat-contacts">
            <ul class="contacts-list">
              <li>
                <a href="#">
                  <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user1-128x128.jpg">
                  <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      Count Dracula
                      <small class="contacts-list-date pull-right">2/28/2015</small>
                    </span>
                    <span class="contacts-list-msg">How have you been? I was...</span>
                  </div><!-- /.contacts-list-info -->
                </a>
              </li><!-- End Contact Item -->
              <li>
                <a href="#">
                  <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user7-128x128.jpg">
                  <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      Sarah Doe
                      <small class="contacts-list-date pull-right">2/23/2015</small>
                    </span>
                    <span class="contacts-list-msg">I will be waiting for...</span>
                  </div><!-- /.contacts-list-info -->
                </a>
              </li><!-- End Contact Item -->
              <li>
                <a href="#">
                  <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user3-128x128.jpg">
                  <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      Nadia Jolie
                      <small class="contacts-list-date pull-right">2/20/2015</small>
                    </span>
                    <span class="contacts-list-msg">I'll call you back at...</span>
                  </div><!-- /.contacts-list-info -->
                </a>
              </li><!-- End Contact Item -->
              <li>
                <a href="#">
                  <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user5-128x128.jpg">
                  <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      Nora S. Vans
                      <small class="contacts-list-date pull-right">2/10/2015</small>
                    </span>
                    <span class="contacts-list-msg">Where is your new...</span>
                  </div><!-- /.contacts-list-info -->
                </a>
              </li><!-- End Contact Item -->
              <li>
                <a href="#">
                  <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user6-128x128.jpg">
                  <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      John K.
                      <small class="contacts-list-date pull-right">1/27/2015</small>
                    </span>
                    <span class="contacts-list-msg">Can I take a look at...</span>
                  </div><!-- /.contacts-list-info -->
                </a>
              </li><!-- End Contact Item -->
              <li>
                <a href="#">
                  <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user8-128x128.jpg">
                  <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      Kenneth M.
                      <small class="contacts-list-date pull-right">1/4/2015</small>
                    </span>
                    <span class="contacts-list-msg">Never mind I found...</span>
                  </div><!-- /.contacts-list-info -->
                </a>
              </li><!-- End Contact Item -->
            </ul><!-- /.contatcts-list -->
          </div><!-- /.direct-chat-pane -->
        </div><!-- /.box-body -->
        <div class="box-footer">
          <form action="#" method="post">
            <div class="input-group">
              <input type="text" name="message" placeholder="Type Message ..." class="form-control">
              <span class="input-group-btn">
                <button type="button" class="btn btn-warning btn-flat">Send</button>
              </span>
            </div>
          </form>
        </div><!-- /.box-footer-->
      </div><!--/.direct-chat -->
    </section>

    <section class="col-lg-4 connectedSortable">
      <!-- USERS LIST -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Latest Members</h3>
          <div class="box-tools pull-right">
            <span class="label label-danger">8 New Members</span>
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
          <ul class="users-list clearfix">
            <li>
              <img src="<?= $directoryAsset ?>/img/user1-128x128.jpg" alt="User Image">
              <a class="users-list-name" href="#">Alexander Pierce</a>
              <span class="users-list-date">Today</span>
            </li>
            <li>
              <img src="<?= $directoryAsset ?>/img/user8-128x128.jpg" alt="User Image">
              <a class="users-list-name" href="#">Norman</a>
              <span class="users-list-date">Yesterday</span>
            </li>
            <li>
              <img src="<?= $directoryAsset ?>/img/user7-128x128.jpg" alt="User Image">
              <a class="users-list-name" href="#">Jane</a>
              <span class="users-list-date">12 Jan</span>
            </li>
            <li>
              <img src="<?= $directoryAsset ?>/img/user6-128x128.jpg" alt="User Image">
              <a class="users-list-name" href="#">John</a>
              <span class="users-list-date">12 Jan</span>
            </li>
            <li>
              <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" alt="User Image">
              <a class="users-list-name" href="#">Alexander</a>
              <span class="users-list-date">13 Jan</span>
            </li>
            <li>
              <img src="<?= $directoryAsset ?>/img/user5-128x128.jpg" alt="User Image">
              <a class="users-list-name" href="#">Sarah</a>
              <span class="users-list-date">14 Jan</span>
            </li>
            <li>
              <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg" alt="User Image">
              <a class="users-list-name" href="#">Nora</a>
              <span class="users-list-date">15 Jan</span>
            </li>
            <li>
              <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" alt="User Image">
              <a class="users-list-name" href="#">Nadia</a>
              <span class="users-list-date">15 Jan</span>
            </li>
          </ul><!-- /.users-list -->
        </div><!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="javascript::" class="uppercase">View All Users</a>
        </div><!-- /.box-footer -->
      </div><!--/.box -->
    </section><!-- /.Left col -->

    <section class="col-lg-4 connectedSortable">
    	<!-- TABLE: LATEST ORDERS -->
		<div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Latest Orders</h3>
			  <div class="box-tools pull-right">
			    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			  </div>
			</div><!-- /.box-header -->
			<div class="box-body">
			  <div class="table-responsive">
			    <table class="table no-margin">
			      <thead>
			        <tr>
			          <th>Order ID</th>
			          <th>Item</th>
			          <th>Status</th>
			          <th>Popularity</th>
			        </tr>
			      </thead>
			      <tbody>
			        <tr>
			          <td><a href="pages/examples/invoice.html">OR9842</a></td>
			          <td>Call of Duty IV</td>
			          <td><span class="label label-success">Shipped</span></td>
			          <td><div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div></td>
			        </tr>
			        <tr>
			          <td><a href="pages/examples/invoice.html">OR1848</a></td>
			          <td>Samsung Smart TV</td>
			          <td><span class="label label-warning">Pending</span></td>
			          <td><div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div></td>
			        </tr>
			        <tr>
			          <td><a href="pages/examples/invoice.html">OR7429</a></td>
			          <td>iPhone 6 Plus</td>
			          <td><span class="label label-danger">Delivered</span></td>
			          <td><div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div></td>
			        </tr>
			        <tr>
			          <td><a href="pages/examples/invoice.html">OR7429</a></td>
			          <td>Samsung Smart TV</td>
			          <td><span class="label label-info">Processing</span></td>
			          <td><div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div></td>
			        </tr>
			        <tr>
			          <td><a href="pages/examples/invoice.html">OR1848</a></td>
			          <td>Samsung Smart TV</td>
			          <td><span class="label label-warning">Pending</span></td>
			          <td><div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div></td>
			        </tr>
			        <tr>
			          <td><a href="pages/examples/invoice.html">OR7429</a></td>
			          <td>iPhone 6 Plus</td>
			          <td><span class="label label-danger">Delivered</span></td>
			          <td><div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div></td>
			        </tr>
			        <tr>
			          <td><a href="pages/examples/invoice.html">OR9842</a></td>
			          <td>Call of Duty IV</td>
			          <td><span class="label label-success">Shipped</span></td>
			          <td><div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div></td>
			        </tr>
			      </tbody>
			    </table>
			  </div><!-- /.table-responsive -->
			</div><!-- /.box-body -->
			<div class="box-footer clearfix">
			  <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
			  <a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
			</div><!-- /.box-footer -->
		</div><!-- /.box -->
    </section><!-- right col -->

  </div><!-- /.row -->

  <div class="row>">
    
    <section class="col-lg-4 connectedSortable">
    	<!-- Info Boxes Style 2 -->
		<div class="info-box bg-yellow">
			<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text">Inventory</span>
			  <span class="info-box-number">5,200</span>
			  <div class="progress">
			    <div class="progress-bar" style="width: 50%"></div>
			  </div>
			  <span class="progress-description">
			    50% Increase in 30 Days
			  </span>
			</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
			<div class="info-box bg-green">
			<span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text">Mentions</span>
			  <span class="info-box-number">92,050</span>
			  <div class="progress">
			    <div class="progress-bar" style="width: 20%"></div>
			  </div>
			  <span class="progress-description">
			    20% Increase in 30 Days
			  </span>
			</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
			<div class="info-box bg-red">
			<span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text">Downloads</span>
			  <span class="info-box-number">114,381</span>
			  <div class="progress">
			    <div class="progress-bar" style="width: 70%"></div>
			  </div>
			  <span class="progress-description">
			    70% Increase in 30 Days
			  </span>
			</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
			<div class="info-box bg-aqua">
			<span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text">Direct Messages</span>
			  <span class="info-box-number">163,921</span>
			  <div class="progress">
			    <div class="progress-bar" style="width: 40%"></div>
			  </div>
			  <span class="progress-description">
			    40% Increase in 30 Days
			  </span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
    </section>

    <section class="col-lg-4 connectedSortable">
	  <div class="box box-default">
	    <div class="box-header with-border">
	      <h3 class="box-title">Browser Usage</h3>
	      <div class="box-tools pull-right">
	        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	      </div>
	    </div><!-- /.box-header -->
	    <div class="box-body">
	      <div class="row">
	        <div class="col-md-8">
	          <div class="chart-responsive">
	            <canvas id="pieChart" height="150"></canvas>
	          </div><!-- ./chart-responsive -->
	        </div><!-- /.col -->
	        <div class="col-md-4">
	          <ul class="chart-legend clearfix">
	            <li><i class="fa fa-circle-o text-red"></i> Chrome</li>
	            <li><i class="fa fa-circle-o text-green"></i> IE</li>
	            <li><i class="fa fa-circle-o text-yellow"></i> FireFox</li>
	            <li><i class="fa fa-circle-o text-aqua"></i> Safari</li>
	            <li><i class="fa fa-circle-o text-light-blue"></i> Opera</li>
	            <li><i class="fa fa-circle-o text-gray"></i> Navigator</li>
	          </ul>
	        </div><!-- /.col -->
	      </div><!-- /.row -->
	    </div><!-- /.box-body -->
	    <div class="box-footer no-padding">
	      <ul class="nav nav-pills nav-stacked">
	        <li><a href="#">United States of America <span class="pull-right text-red"><i class="fa fa-angle-down"></i> 12%</span></a></li>
	        <li><a href="#">India <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 4%</span></a></li>
	        <li><a href="#">China <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>
	      </ul>
	    </div><!-- /.footer -->
	  </div><!-- /.box -->
    </section>

    <section class="col-lg-4 connectedSortable">
	  <!-- PRODUCT LIST -->
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Recently Added Products</h3>
	      <div class="box-tools pull-right">
	        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	      </div>
	    </div><!-- /.box-header -->
	    <div class="box-body">
	      <ul class="products-list product-list-in-box">
	        <li class="item">
	          <div class="product-img">
	            <img src="<?= $directoryAsset ?>/img/default-50x50.gif" alt="Product Image">
	          </div>
	          <div class="product-info">
	            <a href="javascript::;" class="product-title">Samsung TV <span class="label label-warning pull-right">$1800</span></a>
	            <span class="product-description">
	              Samsung 32" 1080p 60Hz LED Smart HDTV.
	            </span>
	          </div>
	        </li><!-- /.item -->
	        <li class="item">
	          <div class="product-img">
	            <img src="<?= $directoryAsset ?>/img/default-50x50.gif" alt="Product Image">
	          </div>
	          <div class="product-info">
	            <a href="javascript::;" class="product-title">Bicycle <span class="label label-info pull-right">$700</span></a>
	            <span class="product-description">
	              26" Mongoose Dolomite Men's 7-speed, Navy Blue.
	            </span>
	          </div>
	        </li><!-- /.item -->
	        <li class="item">
	          <div class="product-img">
	            <img src="<?= $directoryAsset ?>/img/default-50x50.gif" alt="Product Image">
	          </div>
	          <div class="product-info">
	            <a href="javascript::;" class="product-title">Xbox One <span class="label label-danger pull-right">$350</span></a>
	            <span class="product-description">
	              Xbox One Console Bundle with Halo Master Chief Collection.
	            </span>
	          </div>
	        </li><!-- /.item -->
	        <li class="item">
	          <div class="product-img">
	            <img src="<?= $directoryAsset ?>/img/default-50x50.gif" alt="Product Image">
	          </div>
	          <div class="product-info">
	            <a href="javascript::;" class="product-title">PlayStation 4 <span class="label label-success pull-right">$399</span></a>
	            <span class="product-description">
	              PlayStation 4 500GB Console (PS4)
	            </span>
	          </div>
	        </li><!-- /.item -->
	      </ul>
	    </div><!-- /.box-body -->
	    <div class="box-footer text-center">
	      <a href="javascript::;" class="uppercase">View All Products</a>
	    </div><!-- /.box-footer -->
	  </div><!-- /.box -->
    </section>

  </div><!-- /.row -->

</section>

