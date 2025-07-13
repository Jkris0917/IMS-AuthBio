<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register with Face</title>
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
</head>

<body>
    <h2>Register</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="text" name="fname" placeholder="Name" required><br>
        <input type="text" name="mname" placeholder="Name" required><br>
        <input type="text" name="lname" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>

        <video id="video" width="300" height="250" autoplay muted></video>
        <canvas id="canvas" width="300" height="250" style="display: none;"></canvas>

        <input type="hidden" name="face_descriptor" id="face_descriptor">
        <input type="hidden" name="face_image" id="face_image">

        <button type="button" onclick="captureFace()">Capture Face</button><br><br>
        <button type="submit">Register</button>
    </form>

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
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            document.getElementById('face_image').value = canvas.toDataURL('image/png');

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

</body>

</html>
