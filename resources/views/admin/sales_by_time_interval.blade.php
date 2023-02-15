<div class="card">
    <div class="card-header">
        <h3>Sales by Time Interval</h3>
    </div>
    <div class="card-block sbquarter">
        <div class="col-sm-12">
            <div id="bar-chart-new"></div>
            <div class="d-block w-100 text-center">
                <div class="brand-label-sec">
                    <div class="last-year"><span class="ly-bg"></span>Transition</div>
                    <div class="last-year"><span class="cy-bg"></span>Quantity</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('theme/js/raphael.min.js') }}"></script>
<script src="{{ asset('theme/js/morris.js') }}"></script>
<script>
    Morris.Bar({
            element: 'bar-chart-new',
            data: <?php echo $barChartNewJson; ?>,
            xkey: 'y',
            // hideHover: 'auto',
            xLabelAngle: 15,
            ykeys: ['a', 'b'],
            labels: ['Transition', 'Quantity'],
            resize: true,
            barColors: ['#AB96F1', '#24DEAE'],
        });
</script>