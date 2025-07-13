@include('layout.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Update Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Success, Error, and Validation Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset($user->face_image_path) }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->lname }}, {{ $user->fname }}</h3>

                            <p class="text-muted text-center">{{ $user->role }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity"
                                        data-toggle="tab">Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <form class="form-horizontal" action="{{ route('user.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <!-- Full Name Fields -->
                                        <div class="form-group row">
                                            <label for="inputFname" class="col-sm-2 col-form-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputFname"
                                                    name="fname" placeholder="First Name"
                                                    value="{{ old('fname', $user->fname) }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputMname" class="col-sm-2 col-form-label">Middle Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputMname"
                                                    name="mname" placeholder="Middle Name"
                                                    value="{{ old('mname', $user->mname) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputLname" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputLname"
                                                    name="lname" placeholder="Last Name"
                                                    value="{{ old('lname', $user->lname) }}" required>
                                            </div>
                                        </div>

                                        <!-- Email and Username -->
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                    name="email" placeholder="Email"
                                                    value="{{ old('email', $user->email) }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputUsername"
                                                    name="username" placeholder="Username"
                                                    value="{{ old('username', $user->username) }}" required>
                                            </div>
                                        </div>

                                        <!-- Password Fields -->
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="inputPassword"
                                                    name="password" placeholder="Leave empty to keep the same">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputPasswordConfirmation"
                                                class="col-sm-2 col-form-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control"
                                                    id="inputPasswordConfirmation" name="password_confirmation"
                                                    placeholder="Confirm Password">
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- /.post -->
                                </div>
                                <!-- /.tab-pane -->
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('layout.footer')
