<?php 
    $orders = $this->common_model->custom_query(
        "   SELECT * FROM `order` 
            WHERE `OD_ID` = $OD_ID AND `OD_Allow` != '3' 
            LIMIT 1 "
    );
    $lists = $this->common_model->custom_query(
        "   SELECT * FROM `order_list` 
            LEFT JOIN `product` ON `order_list`.`P_ID` = `product`.`P_ID` 
            WHERE `OD_ID` = $OD_ID AND `ODL_Allow` = '1' 
            ORDER BY `ODL_DateTimeUpdate` ASC, `ODL_ID` ASC "
    );
    $sums = $this->common_model->custom_query(
        "   SELECT 
            SUM(`ODL_Amount`) AS ODL_Amount, 
            SUM(`ODL_Price`) AS ODL_Price, 
            SUM(`ODL_SumPrice`) AS ODL_SumPrice, 
            SUM(`ODL_FullSumPrice`) AS ODL_FullSumPrice 
            FROM `order_list` 
            WHERE `OD_ID` = $OD_ID AND `ODL_Allow` = '1' "
    );
    $address = $this->common_model->custom_query(
        "   SELECT * FROM `order_address`
            LEFT JOIN `districts`       ON `order_address`.`District_ID`    = `districts`.`District_ID`
            LEFT JOIN `amphures`        ON `order_address`.`Amphur_ID`      = `amphures`.`Amphur_ID`
            LEFT JOIN `provinces`       ON `order_address`.`Province_ID`    = `provinces`.`Province_ID` 
            WHERE `OD_ID` = $OD_ID AND OD_Allow = '1' 
            LIMIT 1 "
    );

    if (count($orders) > 0  && count($lists) > 0 && count($sums) > 0 && count($address) > 0) { ?>
        <div id="order_detail" lang="th">
            <div class="mDiv">
                <div class="ftitle">ข้อมูลการซื้อขาย / สั่งซื้อ</div>
            </div>
            <div class="main-table-box">
                <div class="form-div"> <?php
                    $OD_Status = array(
                        '1' => 'ปกติ',
                        '2' => 'Pre-order'
                    );
                    $OD_Allow = array(
                        '1'  => 'ปกติ',
                        '2'  => 'ระงับ',
                        '3'  => 'ลบ / บล๊อค',
                        '4'  => 'รอตรวจสอบ',
                        '5'  => 'ยืนยันแล้ว',
                        '6'  => 'รอโอนเงิน',
                        '7'  => 'โอนเงินแล้ว',
                        '8'  => 'รอส่งสินค้า',
                        '9'  => 'ส่งสินค้าแล้ว',
                        '10' => 'ได้รับสินค้าแล้ว'
                    );
                    foreach ($orders as $key => $value) { ?>
                        <div class="form-field-box odd">
                            <div class="form-header-box">รหัสใบสั่งซื้อ: </div>
                            <div class="form-display-box"><?php echo $value['OD_Code']; ?></div>
                        </div>
                        <div class="form-field-box even">
                            <div class="form-header-box">รหัส EMS: </div>
                            <div class="form-display-box"><?php echo $value['OD_EmsCode']; ?></div>
                        </div>
                        <div class="form-field-box odd">
                            <div class="form-header-box">ราคารวม: </div>
                            <div class="form-display-box">฿<?php echo number_format($value['OD_SumPrice'], 2); ?></div>
                        </div>
                        <div class="form-field-box even">
                            <div class="form-header-box">ราคาเต็มแบบไม่คิดส่วนลด: </div>
                            <div class="form-display-box">฿<?php echo number_format($value['OD_FullSumPrice'], 2); ?></div>
                        </div>
                        <div class="form-field-box odd">
                            <div class="form-header-box">การซื้อขาย / สั่งซื้อ: </div>
                            <div class="form-display-box"><?php echo $OD_Status[$value['OD_Status']]; ?></div>
                        </div>
                        <div class="form-field-box even">
                            <div class="form-header-box">สถานะ: </div>
                            <div class="form-display-box"><?php echo $OD_Allow[$value['OD_Allow']]; ?></div>
                        </div> <?php
                    } ?>
                </div>
            </div>
            <div class="mDiv">
                <div class="ftitle">รายละเอียดการซื้อขาย / สั่งซื้อ</div>
            </div>
            <div class="main-table-box">
                <div class="bDiv">
                    <table cellspacing="0" cellpadding="0" border="0">
                        <thead>
                            <tr class="hDiv">
                                <th><div class="text-center">สินค้า</div></th>
                                <th><div class="text-center">รายละเอียด / หมายเหตุ</div></th>
                                <th><div class="text-center">จำนวน</div></th>
                                <th><div class="text-center">ราคา</div></th>
                                <th><div class="text-center">ราคารวม</div></th>
                                <th><div class="text-center">ราคาสุทธิ</div></th>
                            </tr>
                        </thead>
                        <tbody> <?php
                            $erow = 1; 
                            foreach ($lists as $key => $value) { ?>
                                <tr <?php if ($erow %2 === 0) { ?> class="erow" <?php } ?>>
                                    <td class="text-normal"><div class="text-left"><?php echo $value['P_Name'].' ('.$value['P_IDCode'].')'; ?></div></td>
                                    <td class="text-normal"><div class="text-left"><?php echo $value['ODL_Descript']; ?></div></td>
                                    <td class="text-numeri"><div class="text-right"><?php echo $value['ODL_Amount']; ?></div></td>
                                    <td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_Price'], 2); ?></div></td>
                                    <td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_SumPrice'], 2); ?></div></td>
                                    <td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_FullSumPrice'], 2); ?></div></td>
                                </tr> <?php
                                $erow += 1; 
                            } ?>
                        </tbody>
                        <tfoot> <?php
                            foreach ($sums as $key => $value) { ?>
                                <tr class="hDiv">
                                    <th class="text-normal"><div class="text-left">รวมทั้งหมด</div></th>
                                    <th class="text-normal"><div class="text-left"></div></th>
                                    <th class="text-numeri"><div class="text-right"><?php echo $value['ODL_Amount']; ?></div></th>
                                    <th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_Price'], 2); ?></div></th>
                                    <th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_SumPrice'], 2); ?></div></th>
                                    <th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_FullSumPrice'], 2); ?></div></th>
                                </tr> <?php 
                            } ?>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="mDiv">
                <div class="ftitle">ข้อมูลติดต่อ และที่อยู่ในการจัดส่ง</div>
            </div>
            <div class="main-table-box">
                <div class="form-div"> <?php
                    foreach ($address as $key => $value) { 
                        $address = 'เลขที่/ห้อง '.$value['OD_hrNumber']; 
                        if ($value['OD_VilBuild'] !== '')
                            $address .= ' หมู่บ้าน/อาคาร/คอนโด '.$value['OD_VilBuild'];
                        if ($value['OD_VilNo'] !== '')
                            $address .= ' หมู่ที่ '.$value['OD_VilNo'];
                        if ($value['OD_LaneRoad'] !== '')
                            $address .= ' ตรอก/ซอย '.$value['OD_LaneRoad'];
                        if ($value['OD_Street'] !== '')
                            $address .= ' ถนน'.$value['OD_Street'];
                        if ($value['Province_ID'] === '1')
                            $address .= ' '.$value['District_Name'].' '.$value['Amphur_Name'].' '.$value['Province_Name'].' '.$value['Zipcode_Code'];
                        else
                            $address .= ' ตำบล'.$value['District_Name'].' อำเภอ'.$value['Amphur_Name'].' จังหวัด'.$value['Province_Name'].' '.$value['Zipcode_Code'];
                        ?>
                        <div class="form-field-box odd">
                            <div class="form-display-box">ชื่อ - นามสกุล: <?php echo $value['OD_Name']; ?></div>
                        </div>
                        <div class="form-field-box even">
                            <div class="form-display-box">ที่อยู่: <?php echo $address; ?></div>
                        </div>
                        <div class="form-field-box odd">
                            <div class="form-display-box">โทรศัพท์: <?php echo $value['OD_Tel']; ?> &nbsp; อีเมล: <?php echo $value['OD_Email']; ?></div>
                        </div>
                        <?php
                    } ?>
                </div>
            </div>
        </div> <?php
    } 
?>