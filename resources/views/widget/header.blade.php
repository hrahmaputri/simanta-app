<!--<div class="container">-->
<nav class="navbar navbar-expand-lg navbar-light custom" style="background-color:rgb(7, 101, 54);">
    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-success">
            <box-icon name="customize"></box-icon>
        </button>

        <i class="fas fa-align-justify"></i>
        <img src="{{URL::asset('img/logodash.png')}}" width="50%" />
    </div>

</nav>
<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
</script>
<!--</div>-->