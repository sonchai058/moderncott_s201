<div id="footer">
    <div id="index-contact">
        <div class="container">
           <div class="col-md-6 contact-detail">
                <p>Siam Triangle Hotel</p>
                <p>
                    <span><?php echo $site['WD_Address'];?></span><br>
                    <span>Tel: <?php echo $site['WD_Tel']; ?> Mob.<?php echo $site['WD_MTel']; ?></span><br>
                    <span>Fax: <?php echo $site['WD_Fax']; ?></span><br>
                    <span>E-mail: <a href="mailto:reservation@newsite.siamtriangle.com"><?php echo $site['WD_Email']; ?></a></span>
                </p>
                <p>
                    <a href="<?php echo $site['WD_FbLink']!=''?$site['WD_FbLink']:'javascript:void(0)';?>" target="_blank"><img src="<?php echo base_url('assets/images/facebook-icon.png');?>" alt=""></a>
                    <a href="<?php echo $site['WD_Ytlink']!=''?$site['WD_Ytlink']:'javascript:void(0)';?>" target="_blank"><img src="<?php echo base_url('assets/images/youtube-icon.png');?>" alt=""></a>
                </p>
                <p>
                    <a href="#" data-toggle="modal" data-target="#myPoll"><i class="fa fa-bar-chart"></i> A satisfaction survey on the resort website.</a>
                </p>
            </div>
            <div class="col-md-6 contact-link">
                <div class="col-md-6 col-sm-6 link1">
                    <p>Follow us on facebook</p>
                    <div class="fb-page" data-href="<?php echo $site['WD_FbLink']; ?>" data-width="100%" data-height="240" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/ServiceTechnologyConsultant"><a href="https://www.facebook.com/ServiceTechnologyConsultant">Service Technology Consultant Co.,Ltd.</a></blockquote></div></div>
                    <!-- <img src="<?php //echo base_url('assets/images/facebookfan.png');?>" alt=""> -->
                </div>
                <div class="col-md-6 col-sm-6 link1">
                    <p>QR Code</p>
                    <img src="<?php echo base_url('assets/images/'.$site['WD_QRCode']);?>" alt="">
                </div>
            </div>
            <div class="clearfix"></div>    
        </div>
    </div>
<nav class="navbar navbar-default navbar-footer">
    <div class="container">
        <p class="text-uppercase text-center" style="padding-top:15px; color:#fff; font-weight:bold;">copyright &copy; 2015 by siam triangle hotel all right reserved.</p>
    </div>
</nav>
</div>
<div id="fb-root"></div>

<div class="modal fade" id="myPoll">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">แบบสำรวจความพึงพอใจที่มีต่อรีสอร์ทและเว็บไซต์</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="job" class="col-sm-offset-1 col-sm-3 control-label">กลุ่มอาชีพ</label>
            <div class="col-sm-5">
                <select name="" id="job" class="form-control">
                    <option value="">เลือกกลุ่มอาชีพ</option>
                    <option value="1">ไม่ระบุ</option>
                    <option value="2">นักเรียน/นักศึกษา</option>
                    <option value="3">พนักงานราชการ</option>
                    <option value="4">พนักงานเอกชน</option>
                    <option value="5">พนักงานของรีสอร์ท</option>
                    <option value="6">ธุรกิจส่วนตัว</option>
                    <option value="7">อื่นๆ</option>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label for="sex" class="col-sm-offset-1 col-sm-3 control-label">เพศ</label>
            <div class="col-sm-5">
                <div class="radio">
                  <label>
                    <input type="radio" name="sex" id="sex" value="1" checked>
                    ชาย
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="sex" id="sex" value="2">
                    หญิง
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="sex" id="sex" value="3">
                    ไม่ระบุ
                  </label>
                </div>
            </div>
          </div>
          <div class="form-group">
            <label for="job" class="col-sm-offset-1 col-sm-3 control-label">กลุ่มช่วงอายุ</label>
            <div class="col-sm-5">
                <select name="" id="job" class="form-control">
                    <option value="">เลือกช่วงอายุ</option>
                    <option value="1">ต่ำกว่า 18 ปี</option>
                    <option value="2">18 - 30 ปี</option>
                    <option value="3">31 - 40 ปี</option>
                    <option value="4">41 - 50 ปี</option>
                    <option value="5">51 - 60 ปี</option>
                    <option value="6">61 ปี ขึ้นไป</option>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-12 text-center">ให้คะแนนเว็บไซต์ของรีสอร์ทเพื่อการบริการที่ดียิ่งขึ้น</label>
            <div class="col-sm-12">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th></th>
                          <th style="text-align:center">1</th>
                          <th style="text-align:center">2</th>
                          <th style="text-align:center">3</th>
                          <th style="text-align:center">4</th>
                          <th style="text-align:center">5</th>
                      </tr>
                  </thead>
                  <tbody class="table-hover">
                      <tr>
                          <td>รูปแบบ ดีไซน์</td>
                          <td style="text-align:center"><input type="radio" name="poll1"></td>
                          <td style="text-align:center"><input type="radio" name="poll1"></td>
                          <td style="text-align:center"><input type="radio" name="poll1"></td>
                          <td style="text-align:center"><input type="radio" name="poll1"></td>
                          <td style="text-align:center"><input type="radio" name="poll1"></td>
                      </tr>
                      <tr>
                          <td>การจัดหมวดหมู่ของเนื้อหา</td>
                          <td style="text-align:center"><input type="radio" name="poll2"></td>
                          <td style="text-align:center"><input type="radio" name="poll2"></td>
                          <td style="text-align:center"><input type="radio" name="poll2"></td>
                          <td style="text-align:center"><input type="radio" name="poll2"></td>
                          <td style="text-align:center"><input type="radio" name="poll2"></td>
                      </tr>
                      <tr>
                          <td>ความง่ายในการใช้งาน</td>
                          <td style="text-align:center"><input type="radio" name="poll3"></td>
                          <td style="text-align:center"><input type="radio" name="poll3"></td>
                          <td style="text-align:center"><input type="radio" name="poll3"></td>
                          <td style="text-align:center"><input type="radio" name="poll3"></td>
                          <td style="text-align:center"><input type="radio" name="poll3"></td>
                      </tr>
                      <tr>
                          <td>ระบบค้นหาข้อมูล</td>
                          <td style="text-align:center"><input type="radio" name="poll4"></td>
                          <td style="text-align:center"><input type="radio" name="poll4"></td>
                          <td style="text-align:center"><input type="radio" name="poll4"></td>
                          <td style="text-align:center"><input type="radio" name="poll4"></td>
                          <td style="text-align:center"><input type="radio" name="poll4"></td>
                      </tr>
                      <tr>
                          <td>ความครบถ้วนของข้อมูล</td>
                          <td style="text-align:center"><input type="radio" name="poll5"></td>
                          <td style="text-align:center"><input type="radio" name="poll5"></td>
                          <td style="text-align:center"><input type="radio" name="poll5"></td>
                          <td style="text-align:center"><input type="radio" name="poll5"></td>
                          <td style="text-align:center"><input type="radio" name="poll5"></td>
                      </tr>
                      <tr>
                          <td>ความเร็วในการโหลดข้อมูล</td>
                          <td style="text-align:center"><input type="radio" name="poll6"></td>
                          <td style="text-align:center"><input type="radio" name="poll6"></td>
                          <td style="text-align:center"><input type="radio" name="poll6"></td>
                          <td style="text-align:center"><input type="radio" name="poll6"></td>
                          <td style="text-align:center"><input type="radio" name="poll6"></td>
                      </tr>
                      <tr>
                          <td>ความพอใจโดยรวม</td>
                          <td style="text-align:center"><input type="radio" name="poll7"></td>
                          <td style="text-align:center"><input type="radio" name="poll7"></td>
                          <td style="text-align:center"><input type="radio" name="poll7"></td>
                          <td style="text-align:center"><input type="radio" name="poll7"></td>
                          <td style="text-align:center"><input type="radio" name="poll7"></td>
                      </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="form-group">
            <label for="job" class="col-sm-12">คำแนะนำหรือความคิดเห็น</label>
            <div class="col-sm-12">
                <textarea class="form-control" name="massage" rows="5"></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-default">บันทึกข้อมูล</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.5&appId=1887480098143229";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>