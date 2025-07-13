@include('layout.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Item List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Item List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('user.create') }}"><button class="btn btn-primary"><i
                                    class="fas fa-user"></i>Add User</button></a>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Initial</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $data)
                                <tr>
                                    <td>
                                        <img src="{{ $data->face_image_path }}" alt="User Image" height="60"
                                            width="60" style="border-radius: 50%; cursor: pointer;"
                                            data-toggle="modal" data-target="#imageModal{{ $data->id }}">
                                    </td>
                                    <td>{{ $data->lname }}</td>
                                    <td>{{ $data->fname }}</td>
                                    <td>{{ strtoupper(substr($data->mname, 0, 1)) }}.</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->username }}</td>
                                    <td>
                                        <form action="{{ route('user.destroy', $data->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal should be outside of <tr> -->
                                <div class="modal fade" id="imageModal{{ $data->id }}" tabindex="-1"
                                    aria-labelledby="imageModalLabel{{ $data->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <img src="{{ $data->face_image_path }}" alt="User Image"
                                                    class="img-fluid rounded">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!--/. container-fluid -->
    </section>
</div>
<!-- /.content-wrapper -->

@include('layout.footer')
