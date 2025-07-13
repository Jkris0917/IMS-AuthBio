<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IMS | Login</title>
    <script defer src="{{ asset('face-api.min.js') }}"></script>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        #bg-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
        }

        /* Header */
        .nav-header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            background: rgba(0, 0, 0, 0.3);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
        }

        .logo {
            width: 35px;
            height: 35px;
        }

        .ims-title {
            font-size: 20px;
            font-weight: bold;
        }

        .nav-right a {
            padding: 8px 40px;
            background-color: limegreen;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        /* Camera */
        .camera-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #video {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 4px solid #00ff00;
            object-fit: cover;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.6);
        }

        #scanning-indicator {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: lime;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.4);
            display: none;
        }

        h2 {
            text-align: center;
            color: white;
            position: absolute;
            top: 20px;
            width: 100%;
        }

        /* Form styles */
        .login-form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .login-form button {
            width: 100%;
            padding: 12px;
            background-color: limegreen;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Background Video -->
    <video id="bg-video" autoplay muted loop>
        <source src="{{ asset('bg.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Header -->
    <header class="nav-header">
        <div class="nav-left">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
            <span class="ims-title">IMS</span>
        </div>
        <div class="nav-right">
            <a href="{{ route('loginForm') }}" id="altLoginLink">Alternative Login</a>
        </div>
    </header>

    <!-- Camera & Face Detection -->
    <div class="camera-container">
        <video id="video" autoplay muted></video>
        <div id="scanning-indicator">Scanning...</div>
    </div>

    <!-- Face Authentication Script -->
    <script>
        window.onload = async function() {
            const indicator = document.getElementById('scanning-indicator');
            indicator.style.display = 'inline-block';
            indicator.textContent = 'Initializing camera...';

            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
                faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
                faceapi.nets.faceRecognitionNet.loadFromUri('/models')
            ]);

            startVideo();
        };

        function startVideo() {
            const video = document.getElementById('video');
            const indicator = document.getElementById('scanning-indicator');

            navigator.mediaDevices.getUserMedia({
                    video: {}
                })
                .then(stream => {
                    video.srcObject = stream;
                    indicator.textContent = 'Camera initialized. Starting scan...';
                    setTimeout(authenticateFace, 2000);
                })
                .catch(err => {
                    console.error('Camera access error:', err);
                    indicator.textContent = 'Unable to access camera.';
                });
        }

        async function authenticateFace() {
            const video = document.getElementById('video');
            const indicator = document.getElementById('scanning-indicator');

            indicator.textContent = 'Scanning...';

            const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (!detection) {
                indicator.textContent = 'No face detected. Move closer.';
                setTimeout(authenticateFace, 3000);
                return;
            }

            // Distance/size check to make sure face is close enough
            const boxWidth = detection.detection.box.width;
            const boxHeight = detection.detection.box.height;

            if (boxWidth < 300 || boxHeight < 300) {
                indicator.textContent = 'Face too far. Please move closer.';
                setTimeout(authenticateFace, 3000);
                return;
            }

            fetch('{{ route('face.login') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        descriptor: Array.from(detection.descriptor)
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        indicator.textContent = 'Successfully Logged In!';
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.dashboard') }}";
                        }, 2000);
                    } else {
                        indicator.textContent = 'Face not recognized. Retrying...';
                        setTimeout(authenticateFace, 3000);
                    }
                })
                .catch(err => {
                    console.error('Error during fetch:', err);
                    indicator.textContent = 'Error occurred. Please try again.';
                });
        }
    </script>

</body>

</html>
