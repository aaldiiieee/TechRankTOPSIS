$(document).ready(function () {
    let currentStream = null;

    $('#btnSubmitForm').on('click', function() {
        let token = $('meta[name="csrf-token"]').attr('content');
        let formDataArray = [];

        $('input[name^="capturedPhotoInput_2"]').each(function() {
            formDataArray.push({
                name: $(this).attr('name'),
                value: $(this).val()
            });
        });

        $.ajax({
            type: 'POST',
            url: '/report-create',
            data: {
                _token: token,
                newForm: formDataArray
            },
            dataType: 'json',
            success: function(data) {
                alert('Data berhasil disimpan!');
                window.location.href = '/customers';
                history.pushState(null, null, '/customers');
                window.onpopstate = function() {
                    history.pushState(null, null, '/customers');
                }
            },
            error: function(err) {
                console.log(err);
            }
        })
    })
    
    // HANDLER FOR STATIC START WEBCAM
    document.getElementById(`btnStartWebcam`).addEventListener('click', function() {
        startWebcam();
        document.getElementById(`btnStartWebcam`).style.display = 'none';
    });

    // HANDLER FOR STARTING WEBCAM FRONT CAMERA
    document.getElementById(`btnFrontCamera`).addEventListener('click', function() {
        startWebcam('user');
        document.getElementById(`btnStartWebcam`).style.display = 'none';
    });

    // HANDLER FOR STARTING WEBCAM BACK CAMERA
    document.getElementById(`btnBackCamera`).addEventListener('click', function() {
        startWebcam('environment');
        document.getElementById(`btnStartWebcam`).style.display = 'none';
    });
    
    // FUNCTION FOR START WEBCAM
    function startWebcam(facingMode) {
        let mediaDevices = navigator.mediaDevices;

        mediaDevices.getUserMedia({
            video: {
                facingMode: facingMode,
            },
            audio: false,
        })
        .then(function(stream) {
            let video = document.getElementById(`webcam`);
            video.srcObject = stream;
            video.style.display = 'block';
            document.getElementById(`btnCapturePhoto`).style.display = 'block';
            document.getElementById(`btnFrontCamera`).style.display = 'block';
            document.getElementById(`btnBackCamera`).style.display = 'block';
            document.getElementById(`btnRetakePhoto`).style.display = 'none';
            document.getElementById(`capturedPhoto`).style.display = 'none';
            video.play();

            document.getElementById(`btnCapturePhoto`).addEventListener('click', function() {
                capturePhoto(stream);
            });
        })
        .catch(function(err) {
            console.log('Error accessing webcam: ' + err);
        });
    }

    // CAPTURE PHOTO
    function capturePhoto(stream) {
        let video = document.getElementById(`webcam`);
        let canvas = document.getElementById(`canvas`);
        let context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Stop the video stream after capturing the photo
        stream.getTracks().forEach(function(track) {
            track.stop();
        });

        // Display the captured photo
        let img = document.getElementById(`capturedPhoto`);
        let inputImage = document.getElementById(`capturedPhotoInput`);
        img.src = canvas.toDataURL('image/png');
        inputImage.value = canvas.toDataURL('image/png');
        img.style.display = 'block';

        // Hide the webcam and Capture button, show Retake button
        video.style.display = 'none';
        document.getElementById(`btnCapturePhoto`).style.display = 'none';
        document.getElementById(`btnRetakePhoto`).style.display = 'block';

        document.getElementById(`btnRetakePhoto`).addEventListener('click', function() {
            startWebcam();
        });
    }

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('input[type="file"]')) {
            const file = e.target.files;

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result

                    img.onload = function() {    
                        const canvas = document.getElementById(`canvas`)
                        const btnCamera = document.getElementById(`btnStartWebcam`)
                        const inputBase64 = document.getElementById(`capturedPhotoInput`)
                        const ctx = canvas.getContext('2d');

                        canvas.width = img.width;
                        canvas.height = img.height;

                        ctx.drawImage(img, 0, 0, img.width, img.height)
                        canvas.style.display = "block";
                        btnCamera.style.display = "none";
                        inputBase64.value = canvas.toDataURL('image/png')
                    }
                    
                }

                reader.readAsDataURL(file)
            }
        }
    });
})