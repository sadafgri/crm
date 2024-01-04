@php use Illuminate\Support\Facades\Storage; @endphp
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

        @include('.header.data.productsData_header')
        <!-- Main content -->

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="accordionHead">
                                @if(auth()->user()->role =='admin')
                                <form role="form" method="get" action="{{route('products.filter')}} ">
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
                                                                <label for="filtername">نام محصول</label>
                                                                <input type="text" class="form-control"
                                                                       id="filter[titel]"
                                                                       name="filter[titel]"
                                                                       placeholder="نام محصول"
                                                                       @if(isset($_GET['filtername']))
                                                                           value="{{$_GET['filtername']}}"
                                                                    @endif>
                                                            </div>
                                                            <div class="col">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="filterprice"> قیمت</label>
                                                                        <label for="filterprice"
                                                                               id="filterprice">از</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filter[PriceMin]" name="filter[priceMin]"
                                                                               placeholder="از"
                                                                               @if(isset($_GET['filterpriceMin']))
                                                                                   value="{{$_GET['filterpriceMin']}}"
                                                                            @endif>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="filterpriceMax">تا</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filter[PriceMax]" name="filter[priceMax]"
                                                                               placeholder="تا"
                                                                               @if(isset($_GET['filterpriceMax']))
                                                                                   value="{{$_GET['filterpriceMax']}}"
                                                                            @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="filtermojodi"> موجودی</label>
                                                                        <label for="filtermojodi"
                                                                               id="filtermojodi">از</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filtermojodiMin" name="filter[mojodiMin]"
                                                                               placeholder="از"
                                                                               @if(isset($_GET['filtermojodiMin']))
                                                                                   value="{{$_GET['filtermojodiMin']}}"
                                                                            @endif>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="filterAgeMax">تا</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filtermojodi" name="filter[mojodiMax]"
                                                                               placeholder="تا"
                                                                               @if(isset($_GET['filtermojodiMax']))
                                                                                   value="{{$_GET['filtermojodiMax']}}"
                                                                            @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-info">فیلتر</button>
                                                    <a href="{{--{{ route('Users_data') }}--}}">
                                                        <button type="button" class="btn btn-warning">حذف فیلتر ها</button>
                                                    </a>
                                                </div>
                                                @endif
                                                    </div>
                                                </div>
                                            </div>
                                </form>
                            </div>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="Data" class="table table-bordered table-striped table table-hover">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>نام کالا</th>
                                    <th>توضیحات</th>
                                    <th>قیمت</th>
                                    <th>موجودی</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($temp = 0)
                                @foreach ($products as $product)
                                    @if($product->status=="enable")
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->titel}}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->inventory }}</td>

                                        <td>
                                            <form action="{{ route('products.edit', ['id' => $product->id]) }}"
                                                  method="get">
                                                <button type="submit"><i
                                                            class="fa-regular fa-pen-to-square fa-flip-horizontal"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('products.destroy', ['id' => $product->id]) }}"
                                                  method="post">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure?')"><i
                                                            class="fa-regular fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>id</th>
                                    <th>نام کالا</th>
                                    <th>توضیحات</th>
                                    <th>قیمت</th>
                                    <th>موجودی</th>
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
            "autoWidth": true,
            "pageLength": 5
        });
    });
</script>

</body>
</html>
