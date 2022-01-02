<?php
    $grand_total = 0;
    if ($cart = $this->cart->contents()) {
        foreach ($cart as $item) {
            $grand_total = $grand_total + $item['subtotal'];
        }
    }
?>
<div class="order_info"> <?php 
    echo form_open('product/save_order', array('class' => 'save_order', 'name' => 'save_order')); 
        echo form_hidden('command'); ?>   
        <div class="order_heading">
            <h1 align="center">Orders Information</h1>
        </div>
        <div class="order_view">
            <table>
                <tr>
                    <td>Order total:</td>
                    <td><strong>฿<?php echo number_format($grand_total, 2); ?></strong></td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td><?php echo form_input(array('name' => 'OD_Name')); ?></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><?php echo form_input(array('name' => 'OD_Tel')); ?></td>
                </tr>
                <tr>
                    <td>No.:</td>
                    <td><?php echo form_input(array('name' => 'OD_hrNumber')); ?></td>
                </tr>
                <tr>
                    <td>Village / building:</td>
                    <td><?php echo form_input(array('name' => 'OD_VilBuild')); ?></td>
                </tr>
                <tr>
                    <td>Village no.:</td>
                    <td><?php echo form_input(array('name' => 'OD_VilNo')); ?></td>
                </tr>
                <tr>
                    <td>Road:</td>
                    <td><?php echo form_input(array('name' => 'OD_Street')); ?></td>
                </tr>
                <tr>
                    <td>Alley:</td>
                    <td><?php echo form_input(array('name' => 'OD_LaneRoad')); ?></td>
                </tr>
                <tr>
                    <td>Province:</td>
                    <td><?php echo form_dropdown(array('name' => 'Province_ID', 'class' => 'Province_ID chosen-select'), $provinces); ?></td>
                </tr>
                <tr>
                    <td>District:</td>
                    <td><?php echo form_dropdown(array('name' => 'Amphur_ID', 'class' => 'Amphur_ID chosen-select')); ?></td>
                </tr>
                <tr>
                    <td>Sub district:</td>
                    <td><?php echo form_dropdown(array('name' => 'District_ID', 'class' => 'District_ID chosen-select')); ?></td>
                </tr>
                <tr>
                    <td>Zipcode:</td>
                    <td><?php echo form_input(array('name' => 'Zipcode_Code', 'class' => 'Zipcode_Code chosen-select')); ?></td>
                </tr>
                <tr>
                    <td>Description / remark:</td>
                    <td><?php echo form_textarea(array('name' => 'OD_Descript')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo form_submit('placeorder', 'Place Order'); ?></td>
                </tr> 
            </table>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(".Province_ID").change(function() {
            var request = $.ajax({
                url: "<?php echo base_url('main/amphurs_selection'); ?>",
                method: "POST",
                data: { Province_ID : $(this).val() }
            });
            request.done(function(msg) {
                console.log(JSON.parse(msg));
                $('.Amphur_ID').find('option').remove().end();
                $.each(JSON.parse(msg), function(i, value) {
                    $('.Amphur_ID').append($('<option>').text(value).attr('value', i));
                });
                $('.Amphur_ID').chosen({
                    no_results_text: 'ไม่พบเขต/อำเภอที่ค้นหา',
                    allow_single_deselect: true
                });
                $('.Amphur_ID').trigger('chosen:updated');
                $('.Amphur_ID').trigger('change');
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });

        $(".Amphur_ID").change(function() {
            var request = $.ajax({
                url: "<?php echo base_url('main/districts_selection'); ?>",
                method: "POST",
                data: { Amphur_ID : $(this).val() }
            });
            request.done(function(msg) {
                console.log(JSON.parse(msg));
                $('.District_ID').find('option').remove().end();
                $.each(JSON.parse(msg), function(i, value) {
                    $('.District_ID').append($('<option>').text(value).attr('value', i));
                });
                $('.District_ID').chosen({
                    no_results_text: 'ไม่พบแขวง/ตำบลที่ค้นหา',
                    allow_single_deselect: true
                });
                $('.District_ID').trigger('chosen:updated');
                $('.District_ID').trigger('change');
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });

        $(".District_ID").change(function() {
            var request = $.ajax({
                url: "<?php echo base_url('main/zipcodes_selection'); ?>",
                method: "POST",
                data: { District_ID : $(this).val() }
            });
            request.done(function(msg) {
                console.log(msg);
                $('.Zipcode_Code').val(msg);
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });

        $(".Province_ID").chosen({
            allow_single_deselect: true,
            disable_search_threshold: 10
        });
        $('.Province_ID').trigger('chosen:updated');
        $('.Province_ID').trigger('change');

    });
</script>