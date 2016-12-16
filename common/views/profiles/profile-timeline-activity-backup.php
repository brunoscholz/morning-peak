<div class="tab-pane" id="activity">
            <!-- novos reviews -->
            <!-- Post -->
            <div class="post">
              <div class="user-block">
                <img class="img-circle img-bordered-sm" src="<?= $directoryAsset ?>/img/user1-128x128.jpg" alt="user image">
                <span class='username'>
                  <a href="#">Jonathan Burke Jr.</a>
                  <a href='#' class='pull-right btn-box-tool'><i class='fa fa-times'></i></a>
                </span>
                <span class='description'>Avaliou {Produto} - 7:30 PM today</span>
              </div><!-- /.user-block -->
              <p>
                Lorem ipsum represents a long-held tradition for designers,
                typographers and the like. Some people hate it and argue for
                its demise, but others ignore the hate as they create awesome
                tools to help create filler text for everyone from bacon lovers
                to Charlie Sheen fans.
              </p>
              <ul class="list-inline">
                <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a></li>
                <li class="pull-right"><a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments (5)</a></li>
              </ul>

              <input class="form-control input-sm" type="text" placeholder="Type a comment">
            </div><!-- /.post -->

            <!-- Post -->
            <div class="post clearfix">
              <div class='user-block'>
                <img class='img-circle img-bordered-sm' src='<?= $directoryAsset ?>/img/user7-128x128.jpg' alt='user image'>
                <span class='username'>
                  <a href="#">Sarah Ross</a>
                  <a href='#' class='pull-right btn-box-tool'><i class='fa fa-times'></i></a>
                </span>
                <span class='description'>Sent you a message - 3 days ago</span>
              </div><!-- /.user-block -->
              <p>
                Lorem ipsum represents a long-held tradition for designers,
                typographers and the like. Some people hate it and argue for
                its demise, but others ignore the hate as they create awesome
                tools to help create filler text for everyone from bacon lovers
                to Charlie Sheen fans.
              </p>

              <form class='form-horizontal'>
                <div class='form-group margin-bottom-none'>
                  <div class='col-sm-9'>
                    <input class="form-control input-sm" placeholder="Response">
                  </div>                          
                  <div class='col-sm-3'>
                    <button class='btn btn-danger pull-right btn-block btn-sm'>Send</button>
                  </div>                          
                </div>                        
              </form>
            </div><!-- /.post -->
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="timeline">
            <!-- The timeline -->
            <ul class="timeline timeline-inverse">
              <!-- timeline time label -->
              <li class="time-label">
                <span class="bg-red">
                  10 Feb. 2014
                </span>
              </li>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-envelope bg-blue"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                  <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-primary btn-xs">Read more</a>
                    <a class="btn btn-danger btn-xs">Delete</a>
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-user bg-aqua"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                  <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-comments bg-yellow"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
                  <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                  <div class="timeline-body">
                    Take me to your leader!
                    Switzerland is small and neutral!
                    We are more like Germany, ambitious and misunderstood!
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline time label -->
              <li class="time-label">
                <span class="bg-green">
                  3 Jan. 2014
                </span>
              </li>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-camera bg-purple"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>
                  <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                  <div class="timeline-body">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <li>
                <i class="fa fa-clock-o bg-gray"></i>
              </li>
            </ul>
          </div><!-- /.tab-pane -->

<p>
    <?= Html::a('Update', ['update', 'id' => $model->sellerId], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->sellerId], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
  </p>