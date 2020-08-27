<link href="/admin_assets/css/jquery.orgchart.min.css" rel="stylesheet">

<style type="text/css">
    #chart-container { height:  620px; }
    .orgchart { background: transparent; }
</style>

<script src="/admin_assets/js/jquery.min.js"></script>
<script src="/admin_assets/js/jquery.orgchart.min.js"></script>
<script src="/admin_assets/js/jquery.orgchart.min.js.map"></script>

<div id="chart-container"></div>

<script type="text/javascript">
    $(function() {

        var datascource = {!! json_encode($children) !!};

        var oc = $('#chart-container').orgchart({
            'data' : datascource,
            'nodeContent': 'title',
        });

    });
</script>