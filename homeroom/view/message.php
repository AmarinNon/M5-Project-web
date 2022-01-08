<!--content area start-->
<div id="content" class="pmd-content inner-page">
  <!--tab start-->
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-sm-3">
        <!-- Title -->
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-06-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">Homeroom Class M.2/3</span>
        </h1>
        <!-- End Title -->
        <div class="section-content">
          <div class="tab-subject">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-stacked nav-outline">
              <li role="presentation" class="active">
                  <a href="#inbox" aria-controls="home" class="pmd-ripple-effect">Inbox</a>
              </li>
              <li role="presentation">
                  <a href="#contact" aria-controls="tab"  class="pmd-ripple-effect">Send message</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-9">
        <!-- Tab panes -->
        <div class="tab-content mt-2">
          <div role="tabpanel" class="tab-pane active" id="inbox">
            <div class="pmd-card pmd-z-depth fill-gray">
              <div class="pmd-card-title">
                <div class="media-body media-middle">
                  <h2 class="pmd-card-title-text">นักเรียน / เลขที่ 10 ด.ช. อนัน อันดา</h2>
                  <span class="text-gray">20/09/2560</span>
                </div>
                <div class="media-right">
                  <button class="btn btn-sm btn-danger">x</button>
                </div>
              </div>
              <div class="pmd-card-body">
                <hr>  
                <p class="ml-4">ครูครับ ผมขอไปถามการบ้านครูได้ไหมครับ</p>
              </div>
            </div>
            <div class="pmd-card pmd-z-depth fill-gray">
              <div class="pmd-card-title">
                <div class="media-body media-middle">
                  <h2 class="pmd-card-title-text">นักเรียน / เลขที่ 10 ด.ช. อนัน อันดา</h2>
                  <span class="text-gray">20/09/2560</span>
                </div>
                <div class="media-right">
                  <button class="btn btn-sm btn-danger">x</button>
                </div>
              </div>
              <div class="pmd-card-body">
                <hr>  
                <p class="ml-4">ครูครับ ผมขอไปถามการบ้านครูได้ไหมครับ</p>
              </div>
            </div>
          </div>

          <div role="tabpanel" class="hidden tab-pane" id="contact">
            <div class="pmd-card pmd-z-depth fill-gray">
              <div class="pmd-card-title">
                <div class="media-body media-middle">
                  <h2 class="pmd-card-title-text">To Parents / Students</h2>
                </div>
              </div>
              <div class="pmd-card-body">
                <div class="form-group">
                  <span class="text-blue">Send message to</span>
                  <select name="" id="" class="form-control select-custom ml-2 " required="required">
                    <option disabled selected>Select Sender</option>
                  </select>
                  <select name="" id="" class="form-control select-custom ml-2 mr-3" required="required">
                    <option disabled selected>Number</option>
                    <?php for($i = 1 ; $i <= 20 ; $i++) { ?>
                      <option value=""><?php echo $i ?></option>
                    <?php } ?>
                  </select>
                  <span>นาย อเนก อินน้อย : ด.ช. ชวิท อินน้อย</span>
                </div>
                <div class="form-group">
                  <textarea name="" id="" class="form-control" rows="4" required="required"></textarea>
                </div>
                <div class="form-group">
                  <button class="btn btn-default-fill">Send message</button>
                </div>
              </div>
            </div>

            <div class="pmd-card pmd-z-depth fill-gray">
              <div class="pmd-card-title">
                <div class="media-body media-middle">
                  <h2 class="pmd-card-title-text">To Teacher</h2>
                </div>
              </div>
              <div class="pmd-card-body">
                <div class="form-group">
                  <span class="text-blue">Send message to</span>
                  <select name="" id="" class="form-control select-custom ml-2 mr-3" required="required">
                    <option disabled selected>Select subjects</option>
                  </select>
                  <span>ครูสมคิด การไกล</span>
                </div>
                <div class="form-group">
                  <textarea name="" id="" class="form-control" rows="4" required="required"></textarea>
                </div>
                <div class="form-group">
                  <button class="btn btn-default-fill">Send message</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tab end -->

</div>
<!-- content area end -->