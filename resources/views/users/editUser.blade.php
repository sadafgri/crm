
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | کاربر جدید</title>
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
        @include('header.editingData.editing_user')
        <!-- /.content-header -->
        <!-- Main row -->
        <section class="content">
            <!-- form start -->
            <div class="container-fluid">
                <form role="form" method="post" action="{{route('users.update',['id' => $user->id])}}">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="email">ایمیل</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="{{$user->email}}" value="{{$user->email}}">
                                @error('email')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="first_name">نام</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                       placeholder="{{$user->first_name}}" value="{{$user->first_name}}">
                                @error('first_name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="last_name">نام خانوادگی</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       placeholder="{{$user->last_name}}" value="{{$user->last_name}}">
                                @error('last_name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="user_name">نام کاربری</label>
                                <input type="text" class="form-control" id="user_name" name="user_name"
                                       placeholder="{{$user->user_name}}" value="{{$user->user_name}}">
                                @error('user_name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="phone_number">شماره همراه</label>
                                <input type="number" class="form-control" id="phone_number" name="phone_number"
                                       placeholder="{{$user->phone_number}}" value="{{$user->phone_number}}">
                                @error('phone_number')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Add the remaining input fields -->
                            <div class="form-group col-4">
                                <label for="age">سن</label>
                                <input type="number" class="form-control" id="age" name="age"
                                       placeholder="{{$user->age}}" value="{{$user->age}}">
                                @error('age')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="country"> کشور</label>
                                <input type="text" class="form-control" id="country" name="country"
                                       placeholder="{{$user->country}}" value="{{$user->country}}">
                                @error('country')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="province">استان</label>
                                <input type="text" class="form-control" id="province" name="province"
                                       placeholder="{{$user->province}}" value="{{$user->province}}">
                                @error('province')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="city">شهر</label>
                                <input type="text" class="form-control" id="city" name="city"
                                       placeholder="{{$user->city}}" value="{{$user->city}}">
                                @error('city')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="gender">جنسیت</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="male" @if($user->gender == "male") selected @endif>مرد</option>
                                    <option value="female" @if($user->gender == "female") selected @endif>زن</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="postal_code">کد پستی</label>
                                        <input type="number" class="form-control" id="postal_code" name="postal_code"
                                               placeholder="{{$user->postal_code}}" value="{{$user->postal_code}}">
                                        @error('postal_code')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="address">آدرس</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                               placeholder="{{$user->address}}" value="{{$user->address}}">
                                        @error('address')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">ارسال</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </section>
    </div>
    <!-- /.card -->


    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
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
@include('.scripts')
</body>

</html>
