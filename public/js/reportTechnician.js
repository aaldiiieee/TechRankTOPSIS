$(document).ready(function () {
    let formCount = 1;

    $('#btnAddForm').on('click', function () {
        formCount++;

        let newTechReport = $('.ac-report').first().clone();

        newTechReport.find('input, img, video, canvas, button, select, label').each(function() {
            let idAttr = $(this).attr('id');
            
            if (idAttr) {
                $(this).attr('id', idAttr.replace(/_\d+/, `_${formCount}`));
            }
        
            if ($(this).is('input, select, textarea')) {
                let nameAttr = $(this).attr('name');
                if (nameAttr) {
                    $(this).attr('name', nameAttr.replace(/_\d+/, `_${formCount}`));
                }
                $(this).val("");
            }
        
            if ($(this).is('img')) {
                $(this).attr('src', "").attr('style', "display: none;");
            }

            if ($(this).is('canvas')) {
                $(this).attr('style', "display: none;");
            }

            if ($(this).is(`#btnRetakePhoto_${formCount}`)) {
                $(this).attr('style', "display: none;");
            }

            if ($(this).is(`#photoInput_${formCount}`)) {
                $(this).attr('data-form-count', formCount)
            }

            if ($(this).is(`#btnFrontCamera_${formCount}, #btnBackCamera_${formCount}`)) {
                $(this).attr('style', "display: none;");
            }

            if ($(this).is(`#btnStartWebcam_${formCount}`)) {
                $(this).attr('style', "display: block;");
            }

            if ($(this).is(`#btnPhotoInput_${formCount}`)) {
                $(this).attr('for', `photoInput_${formCount}`);
            }
        });
        
        newTechReport.find('.card-header h6').each(function() {
            let text = $(this).text();
            $(this).text(text.replace(/\d+/, formCount));
        });
        

        $('#TechReportContainer').append(newTechReport);
        
        document.getElementById(`btnStartWebcam_${formCount}`).addEventListener('click', function() {
            startWebcam(formCount);
            this.style.display = 'none';
        });
        
        // HANDLER FOR STARTING WEBCAM FRONT CAMERA
        document.getElementById(`btnFrontCamera_${formCount}`).addEventListener('click', function() {
            startWebcam(formCount, 'user');
            document.getElementById(`btnStartWebcam_${formCount}`).style.display = 'none';
        });

        // HANDLER FOR STARTING WEBCAM BACK CAMERA
        document.getElementById(`btnBackCamera_${formCount}`).addEventListener('click', function() {
            startWebcam(formCount, 'environment');
            document.getElementById(`btnStartWebcam_${formCount}`).style.display = 'none';
        });
    });

    $('#btnSubmitForm').on('click', function() {
        let token = $('meta[name="csrf-token"]').attr('content');
        let formDataArray = newTechReport.serializeArray();

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
                console.log(data);
            },
            error: function(err) {
                console.log(err);
            }
        })
    })
    
    // HANDLER FOR STATIC START WEBCAM
    document.getElementById(`btnStartWebcam_${formCount}`).addEventListener('click', function() {
        startWebcam(1);
        document.getElementById(`btnStartWebcam_${formCount}`).style.display = 'none';
    });

    // HANDLER FOR STARTING WEBCAM FRONT CAMERA
    document.getElementById(`btnFrontCamera_${formCount}`).addEventListener('click', function() {
        startWebcam(1, 'user');
        document.getElementById(`btnStartWebcam_${formCount}`).style.display = 'none';
    });

    // HANDLER FOR STARTING WEBCAM BACK CAMERA
    document.getElementById(`btnBackCamera_${formCount}`).addEventListener('click', function() {
        startWebcam(1, 'environment');
        document.getElementById(`btnStartWebcam_${formCount}`).style.display = 'none';
    });
    
    // FUNCTION FOR START WEBCAM
    function startWebcam(count, facingMode) {
        let mediaDevices = navigator.mediaDevices;

        mediaDevices.getUserMedia({
            video: {
                facingMode: facingMode,
            },
            audio: false,
        })
        .then(function(stream) {
            let video = document.getElementById(`webcam_${count}`);
            video.srcObject = stream;
            video.style.display = 'block';
            document.getElementById(`btnCapturePhoto_${count}`).style.display = 'block';
            document.getElementById(`btnFrontCamera_${formCount}`).style.display = 'block';
            document.getElementById(`btnBackCamera_${formCount}`).style.display = 'block';
            document.getElementById(`btnRetakePhoto_${count}`).style.display = 'none';
            document.getElementById(`capturedPhoto_${count}`).style.display = 'none';
            video.play();

            document.getElementById(`btnCapturePhoto_${count}`).addEventListener('click', function() {
                capturePhoto(stream, count);
            });
        })
        .catch(function(err) {
            console.log('Error accessing webcam: ' + err);
        });
    }

    // CAPTURE PHOTO
    function capturePhoto(stream, count) {
        let video = document.getElementById(`webcam_${count}`);
        let canvas = document.getElementById(`canvas_${count}`);
        let context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Stop the video stream after capturing the photo
        stream.getTracks().forEach(function(track) {
            track.stop();
        });

        // Display the captured photo
        let img = document.getElementById(`capturedPhoto_${count}`);
        let inputImage = document.getElementById(`capturedPhotoInput_${count}`);
        img.src = canvas.toDataURL('image/png');
        inputImage.value = canvas.toDataURL('image/png');
        img.style.display = 'block';

        // Hide the webcam and Capture button, show Retake button
        video.style.display = 'none';
        document.getElementById(`btnCapturePhoto_${count}`).style.display = 'none';
        document.getElementById(`btnRetakePhoto_${count}`).style.display = 'block';

        document.getElementById(`btnRetakePhoto_${count}`).addEventListener('click', function() {
            startWebcam(count);
        });
    }

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('input[type="file"]')) {
            const fileInput = e.target
            const formCountInput = fileInput.getAttribute('data-form-count')
            console.log(formCountInput)
        
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result

                    img.onload = function() {    
                        const canvas = document.getElementById(`canvas_${formCountInput}`)
                        const btnCamera = document.getElementById(`btnStartWebcam_${formCountInput}`)
                        const inputBase64 = document.getElementById(`capturedPhotoInput_${formCountInput}`)
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