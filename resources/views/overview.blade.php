@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <div class="row" style="padding-top:80px;">
            <h1>Penjelasan Sekilas Mengenai Manajemen Talenta</h1>
            <h1 class="mt-4">Employee Directory</h1>
            <table id="employeesTable" class="table table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Birth Date</th>
                        <th>Hired On</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        });
    </script>
</div>
</body>
@endsection