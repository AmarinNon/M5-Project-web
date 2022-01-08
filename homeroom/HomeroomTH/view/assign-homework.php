<!--content area start-->
<div id="content" class="pmd-content inner-page">
  <!--tab start-->
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <!-- Title -->
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-02-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">คณิตศาสตร์หลัก ชั้น ม.2/3</span>
        </h1>
        <!-- End Title -->
      </div>
      
      <div class="col-sm-3">
          <div class="btn-with-icon">
            <a class="btn btn-default" data-toggle="modal" href='#add-homework'>
            <span class="fa fa-plus btn-icon img-circle"></span>เพิ่มงาน</a>
          </div>
          

          <div class="tab-subject mt-3">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-stacked nav-outline">
              <li role="presentation" class="active">
                  <a href="#homework-1" aria-controls="home" class="pmd-ripple-effect">งานครั้งที่ 1</a>
              </li>
              <li role="presentation">
                  <a href="#homework-2" aria-controls="tab"  class="pmd-ripple-effect">งานครั้งที่ 2</a>
              </li>
            </ul>
          </div>
      </div>
      <div class="col-sm-9">
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="homework-1">
            <div class="pmd-card pmd-z-depth fill-gray">
              <div class="pmd-card-title clearfix">
                <div class="media-left pull-left">
                  <h2 class="pmd-card-title-text">ใบงานเรื่องระบบจำนวนจริง</h2>
                </div>
                <div class="media-right pull-right">
                  <h2 class="pmd-card-title-text">ส่ง 13/09/2560</h2>
                </div>
              </div>
              <div class="pmd-card-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam felis ex, dignissim quis metus at, eleifend pulvinar massa. Suspendisse dapibus a lorem quis mattis. Sed commodo, odio sit amet sagittis lobortis, lorem lacus mollis lectus, nec condimentum turpis odio non lacus. Vivamus condimentum maximus libero, ac fringilla nisl mollis et. Nam quis posuere dui, a volutpat felis. Nullam porta ac velit in vulputate. Quisque porttitor, sapien a posuere viverra, dolor lectus vestibulum ante, ut tincidunt felis ipsum eu nibh. Mauris tempor neque ante, non placerat lacus eleifend a. Cras laoreet nisl erat, ac condimentum ex pulvinar in. Quisque tincidunt quis felis in dapibus. Morbi non turpis felis. Proin ac lectus ullamcorper, imperdiet nisi ut, faucibus sem. Nulla mattis orci dui, sed rhoncus justo malesuada ut. Cras porttitor libero et magna tempus, a dapibus erat pretium. Nunc consectetur auctor lacus, a convallis eros varius eget. Nunc varius eleifend tellus, gravida luctus velit scelerisque eu.</p>
                <p>In hac habitasse platea dictumst. Aenean hendrerit posuere neque vitae consectetur. Integer accumsan mi risus, efficitur feugiat nisi fringilla et. Suspendisse potenti. Proin sed nulla egestas, congue risus id, iaculis urna. Maecenas facilisis nunc nisi, in ullamcorper tellus hendrerit ut. Ut fringilla risus dui, quis laoreet est vehicula vel. Nullam et orci a leo pulvinar semper. Phasellus placerat dictum maximus. Cras et risus pulvinar, placerat lectus vitae, luctus neque. Aenean finibus leo at augue accumsan, in consequat nulla malesuada. Nunc elementum mattis lectus in euismod. Aliquam sed ipsum a sapien tincidunt eleifend. Fusce id lacinia libero. Duis ornare semper magna.</p>
                <p>Suspendisse in quam sed tortor rutrum feugiat eu et elit. Nullam id diam ac turpis aliquet molestie non at elit. Ut nunc diam, efficitur nec tincidunt nec, scelerisque a tortor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed ut imperdiet lacus. Aenean vel metus at nisl lacinia egestas. Nunc vitae nisl ex. Donec sagittis eget enim sit amet sagittis. Vivamus fringilla eros ac velit accumsan tincidunt. Nullam id elit non mauris euismod viverra id sit amet nibh.</p>
                <div class="text-right mt-4">
                  <button class="btn btn-default-fill bg-red">ลบงาน</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tab end -->

  <div class="modal fade" id="add-homework">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="">
              <div class="form-group col-sm-2">
                <label for="" class="control-label text-info bigger-110">งานครั้งที่</label>
                <input type="text" id="" class="form-control">
              </div>
              <div class="form-group col-sm-5">
                <label for="" class="control-label text-info bigger-110">ชื่องาน</label>
                <input type="text" id="" class="form-control">
              </div>
              <div class="form-group col-sm-5">
                <label for="" class="control-label text-info bigger-110">งานที่เคยสั่ง</label>
                <select name="" id="" class="form-control" required="required">
                  <option disabled selected>ไม่เลือก</option>
                </select>
                <p class="help-block mt-1 no-margin-bottom">*หากต้องการสั่งงานเหมือนที่ผ่านมา</p>
              </div>
              <div class="form-group col-xs-12">
                <label for="" class="control-label">รายละเอียด</label>
                <textarea name="" id="" class="form-control" rows="10" required="required"></textarea>
              </div>
              <div class="form-group col-sm-2">
                <label for="" class="control-label">ประเภทงาน</label>
                <select name="" id="" class="form-control" required="required">
                  <option value="">งานเดี่ยว</option>
                  <option value="">งานกลุ่ม</option>
                </select>
              </div>
              <div class="form-group col-sm-4">
                <label for="" class="control-label">วันสั่งงาน</label>
                <input type="date" id="" class="form-control">
              </div>
              <div class="form-group col-sm-4">
                <label for="" class="control-label">กำหนดส่ง</label>
                <input type="date" id="" class="form-control">
              </div>
              <div class="form-group col-sm-2">
                <label for="" class="control-label"></label>
                <button type="button" class="btn btn-default-fill">บันทึก</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- content area end -->