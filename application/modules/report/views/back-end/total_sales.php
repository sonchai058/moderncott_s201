<script src="<?php echo base_url('assets/plugin/datepicker/jquery-1.4.4.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugin/datepicker/jquery-ui-1.8.10.offset.datepicker.min.js');?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/plugin/datepicker/jquery-ui.css');?>"/>

<script src="<?php echo base_url('assets/plugin/Highcharts-4.1.8/js/highcharts.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugin/Highcharts-4.1.8/js/modules/exporting.js');?>" type="text/javascript"></script>


<div id="chart_content"></div>

<div class="date_select">
    <?php echo form_open(); ?>
        <label for="date-start">ค้นหา</label>&nbsp;<input name="date-start" type="text" value="<?php if ($total > 0) echo $date_start!=''?$date_start:date("d/m/Y",strtotime($get_date[0]['Date'])); else echo date('d/m/Y'); ?>">&nbsp;
        <label for="date-end">ถึง</label>&nbsp;<input name="date-end"   type="text" value="<?php if ($total > 0) echo $date_end!=''?$date_end:date("d/m/Y",strtotime($get_date[count($get_date) - 1]['Date'])); else echo date('d/m/Y'); ?>">&nbsp;
        <input type="submit" name="bt_submit1" value="ค้นหา" title="ค้นหา">
    <?php echo form_close();?>
</div>

<div id="stat_rs">
    <?php 
        if ($date_start != '' && $date_end != '') {
            echo "วันที่ ".formatDateThai(dateChange($date_start,2))." - วันที่ ".formatDateThai(dateChange($date_end,2))."<br>";
        } else {
            if (isset($get_date[0]['Date']) && isset($get_date[count($get_date)-1]['Date']))
                echo "วันที่ ".formatDateThai($get_date[0]['Date'])." - วันที่ ".formatDateThai($get_date[count($get_date)-1]['Date'])."<br>";
        }
        echo "ยอดการขายทั้งหมด : ฿".number_format($total, 2)." ";
    ?>
</div>


<script type="text/javascript">
	$("input[name='date-start']").datepicker({
        altField: this,
        dateFormat: 'dd/mm/yy', 
        changeMonth: true, 
        changeYear: true,
        gotoCurrent: true,
        autoSize: true,
        maxDate: '0',
        onClose: function( selectedDate ) {
		    $("input[name='date-end']").datepicker( "option", "minDate", selectedDate );
		}
    });
	$("input[name='date-end']").datepicker({
        altField: this,
        dateFormat: 'dd/mm/yy', 
        changeMonth: true, 
        changeYear: true,
        gotoCurrent: true,
        autoSize: true,
        maxDate: '0',
        onClose: function( selectedDate ) {
		    $("input[name='date-start']").datepicker( "option", "maxDate", selectedDate );
		}
    });
    $('#chart_content').highcharts({
        chart: {
            zoomType: 'x'
        },
        title: {
            text: '<span style="font-size:22px; font-weight:600; padding-top: 20px;">ยอดการขาย</span>'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%b \'%y',
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'อัตรา ยอดขาย'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }

        },
        tooltip: {
            headerFormat: '<span style="font-size:22px;font-weight:600;">{point.key}</span><br>',
            pointFormat: 'ยอดการขาย: <b>฿{point.y:.2f}</b>'
        },
        series: [{
            type: 'area',
            data: [<?php 
                foreach ($get_date as $key => $value) {
                    $date = explode("-", $value['Date']);
                    $date_m = ($date[1]-1);
                    echo "[Date.UTC($date[0], $date_m, $date[2]), {$price[$key]}],";
                }
            ?>],
        }]
    });
</script>