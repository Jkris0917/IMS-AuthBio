@include('layout.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add User</li>
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
        <div class="container-fluid centered">
            <div class="row">
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <input type="hidden" name="face_descriptor" id="face_descriptor">
                    <input type="hidden" name="face_image" id="face_image">
                    <div class="card">
                        <div class="card-body d-flex justify-content-start align-items-start">
                            <div>
                                <video id="video" width="250" height="180" autoplay muted
                                    style="border: 1px solid #ccc;"></video>
                                <br>
                                <button type="button" class="btn btn-primary mt-2" onclick="captureFace()"><i
                                        class="fas fa-camera"></i>
                                    Capture Face</button>
                                <canvas id="canvas" width="300" height="250" style="display: none;"></canvas>

                            </div>

                            <div class="ml-4 text-center">
                                <label>Preview:</label><br>
                                <img id="preview" src="{{ asset('thumbnail.jpeg') }}" width="250" height="180"
                                    style="border: 1px solid #ccc;" />
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="card col-8">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="lname" id="lname" class="form-control" required
                                    autocomplete="off">
                            </div>
                            <div class="col-4">
                                <label for="">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="fname" id="fname" class="form-control" required
                                    autocomplete="off">
                            </div>
                            <div class="col-4">
                                <label for="">Middle Name <span class="text-danger">*</span></label>
                                <input type="text" name="mname" id="mname" class="form-control" required
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" required
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username" class="form-control" required
                                    autocomplete="off">
                            </div>
                            <div class="col-4">
                                <label for="">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" required
                                    autocomplete="off">
                            </div>
                            <div class="col-4">
                                <label for="">Confirm Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Add User</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('layout.footer')
<script>
    window.onload = function() {
        Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
            faceapi.nets.faceRecognitionNet.loadFromUri('/models')
        ]).then(startVideo);
    };

    function startVideo() {
        navigator.mediaDevices.getUserMedia({
                video: {}
            })
            .then(stream => document.getElementById('video').srcObject = stream);
    }

    async function captureFace() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const preview = document.getElementById('preview');

        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/png');
        document.getElementById('face_image').value = dataUrl;
        preview.src = dataUrl; // ✅ Show preview

        const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (detection) {
            document.getElementById('face_descriptor').value = JSON.stringify(Array.from(detection.descriptor));
            alert("Face captured successfully!");
        } else {
            alert('No face detected. Try again.');
        }
    }
</script>
<script>
    $(document).ready(function() {
        // Check Email
        $('#email').on('blur', function() {
            let email = $(this).val();
            if (email !== '') {
                $.ajax({
                    url: '/check-email',
                    method: 'POST',
                    data: {
                        email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.exists) {
                            alert('Email already exists!');
                            $('#email').addClass('is-invalid');
                        } else {
                            $('#email').removeClass('is-invalid');
                        }
                    }
                });
            }
        });

        // Check Username
        $('#username').on('blur', function() {
            let username = $(this).val();
            if (username !== '') {
                $.ajax({
                    url: '/check-username',
                    method: 'POST',
                    data: {
                        username: username,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.exists) {
                            alert('Username already exists!');
                            $('#username').addClass('is-invalid');
                        } else {
                            $('#username').removeClass('is-invalid');
                        }
                    }
                });
            }
        });
    });
</script>
