@include('admin.header',['Title'=>"Admin - Index"])
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <select class="form-select" id="dashboard-select">
                            <option selected value="1">Class Total Earn</option>
                            <option value="3">Total User</option>
                            <option value="4">Teacher Earn</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="my-4 w-100" id="chart" style="height: 500px;"></div>

        </main>
    </div>
</div>
<!-- Charting library -->
<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<!-- Your application script -->
<script>
    var selection=1;
    var myChart = new Chartisan({
        el: '#chart',
        url: "@chart('sample_chart')"+ "?id="+selection,
    });
    document.getElementById('dashboard-select').addEventListener('change', function() {
        selection=this.value;
        myChart.destroy();
        myChart = new Chartisan({
            el: '#chart',
            url: "@chart('sample_chart')"+ "?id="+selection,
        });
    });

</script>
@include('admin.footer')