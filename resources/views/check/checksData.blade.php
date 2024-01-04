<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | جدول داده</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('.styleSheets.dataStyle')
    @include('.styleSheets.styleSheets')

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    @include('.navbar.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        @include('.Sidebar.Sidebar')
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @include('.header.data.checksData_header')
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="accordionHead">
                                <form role="form" method="get" action="{{ route('checks.filter') }}">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#fillters">
                                                فیلتر ها
                                            </a>
                                        </div>
                                        <div class="collapse" id="fillters" data-bs-parent="#accordionHead">
                                            <div class="card-body">
                                                <div class="form-control">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="filterOrderId ">شماره سفارش</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterOrderId"
                                                                       name="filterOrderId" placeholder="شماره سفارش"
                                                                       @if(isset($_GET['filterOrderId']))
                                                                           value="{{$_GET['filterOrderId']}}"
                                                                        @endif>
                                                            </div>
{{--                                                            <div class="col">--}}
{{--                                                                <label for="filterLastName">نام محصول</label>--}}
{{--                                                                <input type="text" class="form-control"--}}
{{--                                                                       id="filterProductName"--}}
{{--                                                                       name="filterProductName"--}}
{{--                                                                       placeholder="نام محصول "--}}
{{--                                                                       @if(isset($_GET['filterProductName']))--}}
{{--                                                                           value="{{$_GET['filterProductName']}}"--}}
{{--                                                                        @endif>--}}
{{--                                                            </div>--}}
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="filterUserName">نام کاربری</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterUserName"
                                                                       name="filterUserName"
                                                                       placeholder="نام کاربری"
                                                                       @if(isset($_GET['filterUserName']))
                                                                           value="{{$_GET['filterUserName']}}"
                                                                        @endif>
                                                            </div>
                                                            <div class="col">
                                                                <div class="row">

                                                                    <div class="col">
                                                                        <label for="filterOrderTotalPriceMin">قیمت</label>
                                                                        <label for="filterOrderTotalPriceMin"
                                                                               id="filterAge">از</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filterOrderTotalPriceMin" name="filterOrderTotalPriceMin"
                                                                               placeholder="از"
                                                                               @if(isset($_GET['filterOrderTotalPriceMin']))
                                                                                   value="{{$_GET['filterOrderTotalPriceMin']}}"
                                                                                @endif>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="filterOrderTotalPriceMax">تا</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filterOrderTotalPriceMax" name="filterOrderTotalPriceMax"
                                                                               placeholder="تا"
                                                                               @if(isset($_GET['filterOrderTotalPriceMax']))
                                                                                   value="{{$_GET['filterOrderTotalPriceMax']}}"
                                                                                @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-info">فیلتر</button>
{{--                                                <a href="{{ route('Users_data') }}">--}}
                                                    <button type="button" class="btn btn-warning">حذف فیلتر ها</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table id="Data" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>مبلغ فاکتور</th>
                                    <th>لیست محصولات</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($temp = 0)
                                @foreach ($factors as $factor)
                                    <tr>
                                        <td>{{ $factor->order_id }}</td>
                                        <td>{{ $factor->total_price }}</td>
                                        <td>
                                            <a class="btn btn-primary" data-bs-toggle="collapse"
                                               href="#collapseP{{$factor->id}}">
                                                All Products
                                            </a>
                                            <div id="collapseP{{$factor->id}}" class="collapse">
                                                <div class="card-body">
                                                    <table class="table">
                                                        @foreach($factor->order->products as $product)
                                                            <tr>
                                                                <td>Name: {{$product->titel}}</td>
                                                                <td>Price: {{$product->price}}</td>
                                                                <td>Count: {{$product->pivot->count}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form class="" action="{{route('checks.edit',['id'=>$factor->id])}}">
                                            {{--@method('PUT')--}}
                                            <input type="hidden" name="id" value="{{--{{ $user->id }}--}}">
                                            <button type="submit">
                                                <i class="fa-regular fa-pen-to-square fa-flip-horizontal"></i>
                                            </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form class="" action="{{route('checks.destroy',['id'=>$factor->id])}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('Are you sure?')">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>مبلغ فاکتور</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('.footer.main_footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- page script -->

<script>
    $(function () {
        $('#Data').DataTable({
            "language":
                {
                    "paginate":
                        {
                            "next": "بعدی",
                            "previous": "قبلی"
                        },
                    "search": "جست و جو : ",
                },

            "info": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "autoWidth": true
        });
    });
</script>

</body>
</html>
