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
    <link href="{{asset('bt5.css')}}" rel="stylesheet">
    <script src="{{asset('js/bt5.js')}}"></script>
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
        @include('header.adding.addOrder_header')
        <!-- /.content-header -->
        <!-- Main row -->
        <section class="content">
            <!-- form start -->
            <div class="container-fluid">
                <form role="form" method="post" action="{{route('store_order')}}">
                    @csrf
                    <div class="form-group">
                        <div class="col">
                            <label for="order_name">اسم سفارش</label>
                            <input type="text" class="form-control" id="order_name" name="order_name"
                                   placeholder="اسم سفارش">
                        </div>
                        <label for="customer_id">customers</label>
                        <select class="form-control" id="customer_id" name="customer_id">
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">
                                    name: {{$customer->last_name}},
                                    Email: {{$customer->email}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="seller_id">sellers</label>
                        <select class="form-control" id="seller_id" name="seller_id">
                            @foreach($sellers as $seller)
                                <option value="{{$seller->id}}">
                                    name: {{$seller->last_name}},
                                    Email: {{$seller->email}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="product_id">products_available</label>
                            <div class="accordion" id="productAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="productHeading">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#productCollapse" aria-expanded="true"
                                                aria-controls="productCollapse">
                                            Product Information
                                        </button>
                                    </h2>
                                    <div id="productCollapse" class="accordion-collapse collapse show"
                                         aria-labelledby="productHeading">
                                        <div class="accordion-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Product Price</th>
                                                    <th>Amount Available</th>
                                                    <th>Amount Requested</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($products_available as $product)
                                                    <tr>
                                                        <td>{{$product->product_name}}</td>
                                                        <td>{{$product->price}}</td>
                                                        <td>{{$product->amount_available}}</td>
                                                        <td>
                                                            <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                                <button class="btn btn-link px-2" type="button"
                                                                        onclick="changeProductQuantity(this, -1)">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input min="0" name="Product_{{$product->id}}" value="0"
                                                                       type="number"
                                                                       max="{{$product->amount_available}}"
                                                                       class="form-control form-control-sm"
                                                                       style="width: 70px;"/>
                                                                <button class="btn btn-link px-2" type="button"
                                                                        onclick="changeProductQuantity(this, 1)">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function changeProductQuantity(button, step) {
                                    var input = button.parentNode.querySelector('input[type=number]');
                                    input.stepUp(step);
                                }
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="explanations">explanations</label>
                            <textarea class="form-control" id="explanations" name="explanations"
                                      placeholder="explanations"></textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- /.card -->


    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
<!-- /.content -->
<!-- /.content-wrapper -->

@include('.footer.main_footer')

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- ./wrapper -->
@include('.scripts')
</body>

</html>
