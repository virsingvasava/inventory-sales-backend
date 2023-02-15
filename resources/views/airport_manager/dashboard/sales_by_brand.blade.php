<h3>Sale by Brand</h3>
<div id="bar-chart" ></div>
<div class="d-block w-100 text-center">
    <div class="brand-label-sec">
        {{-- <div class="last-year"><span class="ly-bg"></span>Last Year</div> --}}
        <div class="last-year"><span class="cy-bg"></span>Current Year</div>
    </div>
</div>
<script src="{{ asset('theme/js/raphael.min.js') }}"></script>
<script src="{{ asset('theme/js/morris.js') }}"></script>
<script type="text/javascript">
     Morris.Bar({
            element: 'bar-chart',
            data: <?php echo $barChart; ?>,
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Last Year', 'Current Year'],
            resize: true,
            barColors: ['#AB96F1', '#24DEAE'],
        });

      Morris.Area({
            element: 'clasic-area-chart',
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75, b: 65 },
                { y: '2008', a: 50, b: 40},
            ],
            xkey: 'y', ykeys: 'a',
        });

        Morris.Area({
            element: 'insignia-area-chart',
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75, b: 65 },
                { y: '2008', a: 50, b: 40 },
            ],
            xkey: 'y', ykeys: 'a',
        });

        Morris.Area({
            element: 'noir-area-chart',
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75, b: 65 },
                { y: '2008', a: 50, b: 40 },
            ],
            xkey: 'y', ykeys: 'a',
        });

        Morris.Area({
            element: 'goldflakes-area-chart',
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75, b: 65 },
                { y: '2008', a: 50, b: 40 },
            ],
            xkey: 'y', ykeys: 'a',
        });
</script>