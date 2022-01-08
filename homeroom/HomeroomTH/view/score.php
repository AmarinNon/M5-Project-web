<!--content area start-->
<div id="content" class="pmd-content inner-page">
  <!--tab start-->
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-sm-3">
        <!-- Title -->
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-03-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">Homeroom ชั้น ม.2/3</span>
        </h1>
        <!-- End Title -->
        <div class="section-content">
          <div class="btn-with-icon">
            <a href="#" class="btn btn-default">
            <span class="fa fa-plus btn-icon img-circle"></span>เพิ่มวิชา</a>
          </div>

          <div class="tab-subject mt-3">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation" class="active">
                  <a href="#math" aria-controls="home" class="bg-red pmd-ripple-effect">คณิตศาสตร์หลัก ม.2</a>
              </li>
              <li role="presentation">
                  <a href="#science" aria-controls="tab"  class="bg-purple pmd-ripple-effect">วิทยาศาสตร์หลัก ม.2</a>
              </li>
              <li role="presentation">
                  <a href="#hygiene" aria-controls="tab" class="bg-green pmd-ripple-effect">สุขศึกษา ม.2</a>
              </li>
              <li role="presentation">
                  <a href="#career" aria-controls="tab" class="bg-cyan pmd-ripple-effect">การงานอาชีพ ม.2</a>
              </li>
            </ul>
          </div>
          
        </div>
      </div>

      <div class="col-sm-9">
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="math">
              <h1 class="section-title">
                <span>คณิตศาสตร์หลัก ม.2</span>
                <div class="media-top icon-title ml-2 mr-1">
                  <img src="images/svg/icon-01-blue.svg" alt="" class="img-responsive">
                </div>
                <span class="smaller-70">ครูสมคิด การไกล</span>
              </h1>

            <!-- bordered table -->
              <div class="pmd-card">
                <div class="table-responsive">
                  <table class="table pmd-table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>เลขที่</th>
                        <th>รหัส</th>
                        <th>ชื่อ - สกุล</th>
                        <th>mid</th>
                        <th>final</th>
                        <?php for($i = 1 ; $i <= 11 ; $i++) { ?>
                          <th><?php echo $i?></th>
                        <?php } ?>
                        <th>รวม</th>
                      </tr>
                    </thead>
                      <tbody>
                        <?php for($i = 1 ; $i <= 10 ; $i++) { ?>
                        <tr>
                          <td><?php echo $i?></td>
                          <td>4532216</td>
                          <td class="text-left">ด.ญ. กนิกา วงค์ศาสาร</td>
                          <?php for($j = 1 ; $j <= 14 ; $j++) { ?>
                          <td></td>
                          <?php } ?>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div> <!-- bordered table end -->
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tab end -->

</div>
<!-- content area end -->