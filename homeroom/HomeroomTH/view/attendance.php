<!--content area start-->
<div id="content" class="pmd-content inner-page">
  <!--tab start-->
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <!-- Title -->
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-04-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">Homeroom ชั้น ม.2/3</span>
        </h1>
        <!-- End Title -->
      </div>
      <div class="col-sm-3">
          <div class="tab-subject">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-stacked nav-outline">
              <li role="presentation" class="active">
                  <a href="#check" aria-controls="home" class="pmd-ripple-effect">เช็คชื่อเข้าชั้นเรียน</a>
              </li>
              <li role="presentation">
                  <a href="#history" aria-controls="tab"  class="pmd-ripple-effect">ประวัติการขาดเรียน</a>
              </li>
            </ul>
          </div>
      </div>

      <div class="col-sm-9">
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="check">
            <div>
              <span class="text-blue">นักเรียนที่ขาดเรียน</span>
              <select name="" id="" class="form-control select-custom ml-2 mr-2" required="required">
                <option disabled selected>เลขที่</option>
                <?php for($i = 1 ; $i <= 20 ; $i++) { ?>
                  <option value=""><?php echo $i ?></option>
                <?php } ?>
              </select>
              <div class="btn-with-icon">
                <a href="#" class="btn btn-default">
                <span class="fa fa-plus btn-icon img-circle"></span>ขาดเรียน</a>
              </div>
            </div>
          <!-- bordered table -->
            <div class="pmd-card mt-2">
              <div class="table-responsive">
                <table class="table pmd-table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>เลขที่</th>
                      <th>รหัส</th>
                      <th>ชื่อ - สกุล</th>
                      <th>คาบเรียนที่ขาด</th>
                      <th>เวลา</th>
                      <th>วันที่ขาดเรียน</th>
                    </tr>
                  </thead>
                    <tbody>
                      <?php for($i = 1 ; $i <= 5 ; $i++) { ?>
                      <tr>
                        <td><?php echo $i?></td>
                        <td>4532216</td>
                        <td class="text-left">ด.ญ. กนิกา วงค์ศาสาร</td>
                        <td>โฮมรูม</td>
                        <td>08:26</td>
                        <td>24/09/60</td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div> <!-- bordered table end -->
              </div>
          </div>

          <div role="tabpanel" class="hidden tab-pane" id="history">
            <p class="text-info">*รายงานการขาดเรียนจากแต่ละคาบ</p>
          <!-- bordered table -->
            <div class="pmd-card">
              <div class="table-responsive">
                <table class="table pmd-table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>เลขที่</th>
                      <th>รหัส</th>
                      <th>ชื่อ - สกุล</th>
                      <th>คาบเรียนที่ขาด</th>
                      <th>เวลา</th>
                      <th>วันที่ขาดเรียน</th>
                    </tr>
                  </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>4532216</td>
                        <td class="text-left">ด.ญ. กนิกา วงค์ศาสาร</td>
                        <td>
                          <p>โฮมรูม</p>
                          <p>คณิตศาสตร์</p>
                          <p>วิทยาศาสตร์</p>
                          <p>สุขศึกษา</p>
                          <p>การงานอาชีพ</p>
                        </td>
                        <td>
                          <p>08:30</p>
                          <p>09:25</p>
                          <p>10:30</p>
                          <p>11:45</p>
                          <p>13:05</p>
                        </td>
                        <td>20/09/60</td>
                      </tr>
                      <?php for($i = 2 ; $i <= 5 ; $i++) { ?>
                      <tr>
                        <td><?php echo $i?></td>
                        <td>4532217</td>
                        <td class="text-left">ด.ช. ชวิท อินน้อย</td>
                        <td>วิทยาศาตร์</td>
                        <td>08:45</td>
                        <td>24/09/60</td>
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