<!-- =======================HOME PAGE============================== -->

<div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class='bx bxs-home'></i>
                </span> Tổng quan
              </h3>
            </div>
            <div class="row">
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="<?php echo ADMIN_IMAGES_PATH; ?>images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Tài khoản <i class="bx bxs-user mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?=number_format($AmountUser['AmountUser'])?></h2>
                  </div>
                </div>
              </div>
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="<?php echo ADMIN_IMAGES_PATH; ?>images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Sản phẩm <i class="bx bxs-image-alt mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?=number_format($AmountProduct['AmountProduct'])?></h2>
                  </div>
                </div>
              </div>
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="<?php echo ADMIN_IMAGES_PATH; ?>images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Bộ sưu tập <i class="bx bxs-folder mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?=number_format($AmountCollection['AmountCollection'])?></h2>
                  </div>
                </div>
              </div>
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="<?php echo ADMIN_IMAGES_PATH; ?>images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Bình luận <i class="bx bxs-comment mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?=number_format($AmountComment['AmountComment'])?></h2>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Top Doanh Thu</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="text-center"></th>
                            <th> Tài khoản </th>
                            <th> ID </th>
                            <th class="text-end"> Doanh thu </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($topVolume)&&(count($topVolume)>1)): ?>
                          <?php $i=1; foreach($topVolume as $user): ?>
                          <tr>
                            <td class="text-center">
                              <?php if($i==1){
                                echo "<label class='badge badge-gradient-danger'>Top 1</label>";
                              }elseif($i==2){
                                echo "<label class='badge badge-gradient-warning'>Top 2</label>";
                              }elseif($i==3){
                                echo "<label class='badge badge-gradient-success'>Top 3</label>";
                              }elseif($i==4){
                                echo "4";
                              }else{
                                echo "5";
                              }?>
                            </td>
                            <td>
                              <img src="<?php echo USER_PATH; ?><?=$user['AvatarImage']?>" class="me-2" alt="image"> <?=$user['Username']?>
                            </td>
                            <td> #<?=$user['UserID']?> </td>
                            <td class="text-end"> <?=number_format($user['Volume'])?> Coins </td>
                          </tr>
                          <?php $i++;endforeach; ?>                   
                          <?php endif; ?> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Top Coins</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="text-center"></th>
                            <th> Tài khoản </th>
                            <th> ID </th>
                            <th class="text-end"> Coins </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (isset($topCoins)&&(count($topCoins)>1)): ?>
                          <?php $i=1; foreach($topCoins as $user): ?>
                          <tr>
                            <td class="text-center">
                              <?php if($i==1){
                                echo "<label class='badge badge-gradient-danger'>Top 1</label>";
                              }elseif($i==2){
                                echo "<label class='badge badge-gradient-warning'>Top 2</label>";
                              }elseif($i==3){
                                echo "<label class='badge badge-gradient-success'>Top 3</label>";
                              }elseif($i==4){
                                echo "4";
                              }else{
                                echo "5";
                              }?>
                            </td>
                            <td>
                              <img src="<?php echo USER_PATH; ?><?=$user['AvatarImage']?>" class="me-2" alt="image"> <?=$user['Username']?>
                            </td>
                            <td> #<?=$user['UserID']?> </td>
                            <td class="text-end"> <?=number_format($user['Coins'])?> Coins </td>
                          </tr>
                          <?php $i++;endforeach; ?>                   
                          <?php endif; ?> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Top nhà bán chạy</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="text-center"></th>
                            <th> Tài khoản </th>
                            <th> ID </th>
                            <th class="text-end"> Số sản phẩm </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($topSold)&&(count($topSold)>1)): ?>
                          <?php $i=1; foreach($topSold as $user): ?>
                          <tr>
                            <td class="text-center">
                              <?php if($i==1){
                                echo "<label class='badge badge-gradient-danger'>Top 1</label>";
                              }elseif($i==2){
                                echo "<label class='badge badge-gradient-warning'>Top 2</label>";
                              }elseif($i==3){
                                echo "<label class='badge badge-gradient-success'>Top 3</label>";
                              }elseif($i==4){
                                echo "4";
                              }else{
                                echo "5";
                              }?>
                            </td>
                            <td>
                              <img src="<?php echo USER_PATH; ?><?=$user['AvatarImage']?>" class="me-2" alt="image"> <?=$user['Username']?>
                            </td>
                            <td> #<?=$user['UserID']?> </td>
                            <td class="text-end"><?=number_format($user['AmountProduct'])?></td>
                          </tr>
                          <?php $i++;endforeach; ?>                   
                          <?php endif; ?> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Top được theo dõi nhiều nhất</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="text-center"></th>
                            <th> Bộ sưu tập </th>
                            <th> ID </th>
                            <th class="text-end"> Lượt theo dõi </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($topFollowers)&&(count($topFollowers)>1)): ?>
                          <?php $i=1; foreach($topFollowers as $user): ?>
                          <tr>
                            <td class="text-center">
                              <?php if($i==1){
                                echo "<label class='badge badge-gradient-danger'>Top 1</label>";
                              }elseif($i==2){
                                echo "<label class='badge badge-gradient-warning'>Top 2</label>";
                              }elseif($i==3){
                                echo "<label class='badge badge-gradient-success'>Top 3</label>";
                              }elseif($i==4){
                                echo "4";
                              }else{
                                echo "5";
                              }?>
                            </td>
                            <td>
                              <img src="<?php echo USER_PATH; ?><?=$user['AvatarImage']?>" class="me-2" alt="image"> <?=$user['Username']?>
                            </td>
                            <td> #<?=$user['UserID']?> </td>
                            <td class="text-end"> <?=number_format($user['Followers'])?> Followers </td>
                          </tr>
                          <?php $i++;endforeach; ?>                   
                          <?php endif; ?> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          