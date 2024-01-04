<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | داشبورد اول</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('styleSheets.styleSheets')
    <link rel="stylesheet" href="{{asset('persenalCss/app.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    @include('navbar.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        @include('Sidebar.Sidebar')
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        @include('header.adding.addCheck_header')
        <!-- /.content-header -->
        <!-- Main row -->
        <section class="content">
            <!-- form start -->
            <div class="container-fluid">
                <form role="form" method="post" action="{{ route('checks.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="order_id">اسم سفارش</label>
                            <select name="order_id" class="form-control" id="order_id" onchange="updateTotalPrice(this)">
                                <option value="">انتخاب سفارش</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}" data-total-price="{{ $order->total_price }}">
                                        {{ $order->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="total_pay">مبلغ فاکتور</label>
                            <input type="text" class="form-control" id="total_pay" name="total_pay" readonly>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>
                    </div>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var orderSelect = document.getElementById('order_id');
                    updateTotalPrice(orderSelect);
                });

                function updateTotalPrice(selectElement) {
                    if (selectElement.selectedIndex > -1) {
                        var selectedOption = selectElement.options[selectElement.selectedIndex];
                        var totalPrice = selectedOption.getAttribute('data-total-price');
                        document.getElementById('total_pay').value = totalPrice;
                    }
                }
            </script>
        </section>
    </div>
</div>
</body>

</html>
