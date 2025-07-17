<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <link href="/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <script src="/bootstrap-5.3.3-dist/js/bootstrap.js"></script>
    <link href="/css/newstyle.css" rel="stylesheet">
    <link href="/css/dataTables.dataTables.min.css" rel="stylesheet">


    <script src="/js/dataTables.min.js"></script>
    <script src="/js/boxicon.js"></script>
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/chart.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    @stack('css')
</head>

<body>
    <div class="wrapper">
        @include('widget.menu')
        <div id="content">
            @include('widget.header')
            @yield('container')
            @stack('scripts')
        </div>

    </div>
</body>
<script>
    $(document).ready(function() {
        $("#dataTable").DataTable();
    });
</script>

@if (session('message'))
<script>
    swal("Message", "{{ session('message') }}", 'success'), {
        button: true,
        button: "OK",
        timer: 3000,
        dangerMode: true
    };
</script>
@endif

</html>