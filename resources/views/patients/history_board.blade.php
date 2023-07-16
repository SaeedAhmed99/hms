<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الرسم</title>
    <!-- ربط Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        #canvas-container {
          position: relative;
          width: 100%;
          height: 100%;
          height: 80vh;
          
      }

      canvas {
          border: 2px solid #3a3737;
          border-radius: 8px;
          width: 100%;
          height: 100%;
      }

      .navbar {
          margin-bottom: 20px;
      }

      .navbar .btn {
          margin-right: 10px;
      }

      .form-inline {
        margin: auto;
      }

      .options {
        margin: auto;
      }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <!-- <span class="navbar-brand mb-0 h1">لوحة الرسم</span> -->
        <div class="form-inline">
            <label for="font-size">حجم الخط:</label>
            <input type="range" class="form-control-range mr-2 mb-2" id="font-size" min="1" max="10" step="1" value="4">
            <div class="options">
              <input type="color" class="form-control mr-2 mt-3" id="color">
              <button class="btn btn-primary mt-3" id="eraser-button">ممحاة</button>
              <button class="btn btn-danger mt-3" id="clear-button">مسح</button>
              <button class="btn btn-success mt-3" id="save-button">حفظ الصورة</button>
              <a href="{{ url()->previous() }}"><button class="btn btn-primary mt-3">رجوع</button></a>
            </div>
        </div>
    </nav>
    <input type="number" id="app_id" value="{{ $id }}" hidden>
    <div class="container-fluid h-100">
      <div class="row h-100">
          <div class="col-12 d-flex align-items-center justify-content-center">
              <div id="canvas-container">
                  <canvas id="canvas"></canvas>
              </div>
          </div>
      </div>
  </div>

    <!-- ربط مكتبة Bootstrap السكريبت -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
      $(document).on('click', '#eraser-button', function (e) {
        if ($("#eraser-button").text() == 'قلم') {
          $("#eraser-button").text("ممحاة");
        } else {
          $("#eraser-button").text("قلم");
        }
      });

        $(document).ready(function() {
            var canvasContainer = document.getElementById("canvas-container");
            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext("2d");

            resizeCanvas();

            $(window).on("resize", resizeCanvas);

            function resizeCanvas() {
                canvas.width = canvasContainer.offsetWidth;
                canvas.height = canvasContainer.offsetHeight;
            }

            var fontSizeInput = document.getElementById("font-size");
            var colorInput = document.getElementById("color");
            var clearButton = document.getElementById("clear-button");
            var eraserButton = document.getElementById("eraser-button");
            var saveButton = document.getElementById("save-button");

            var fontSize = fontSizeInput.value;
            var color = colorInput.value;

            $(fontSizeInput).on("input", function() {
                fontSize = fontSizeInput.value;
            });

            $(colorInput).on("input", function() {
                color = colorInput.value;
            });

            $(clearButton).on("click", function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });

            var isDrawing = false;
            var isErasing = false;
            var previousX = 0;
            var previousY = 0;

            function startDrawing(event) {
                event.preventDefault();
                isDrawing = true;
                if (isErasing) {
                    ctx.globalCompositeOperation = "destination-out";
                } else {
                    ctx.globalCompositeOperation = "source-over";
                }
                previousX = event.pageX - canvas.getBoundingClientRect().left;
                previousY = event.pageY - canvas.getBoundingClientRect().top;
            }

            function draw(event) {
              event.preventDefault();
              if (isDrawing) {
                  var currentX = event.pageX - canvas.getBoundingClientRect().left;
                  var currentY = event.pageY - canvas.getBoundingClientRect().top;

                  ctx.beginPath();
                  ctx.moveTo(previousX, previousY);
                  ctx.lineTo(currentX, currentY);
                  ctx.strokeStyle = color;
                  ctx.lineWidth = fontSize;
                  ctx.lineCap = "round";

                  // تعيين لون الظل للخط
                  ctx.shadowColor = color;
                  // تعيين حجم الظل للخط (زيادة القيمة لجعل الخط أكثر غمقًا)
                  ctx.shadowBlur = 0;
                  ctx.stroke();

                  previousX = currentX;
                  previousY = currentY;
              }
          }

      



            function stopDrawing() {
                isDrawing = false;
            }

            $(eraserButton).on("click", function() {
                isErasing = !isErasing;
                if (isErasing) {
                    eraserButton.classList.add("active");
                } else {
                    eraserButton.classList.remove("active");
                }
            });

            $(saveButton).on("click", function() {
                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = canvas.width;
                tempCanvas.height = canvas.height;

                const tempContext = tempCanvas.getContext('2d');
                tempContext.fillStyle = '#ffffff';
                tempContext.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
                tempContext.drawImage(canvas, 0, 0);

                const dataURL = tempCanvas.toDataURL('image/png');
                const link = document.createElement('a');
                link.href = dataURL;
                
                // var image = canvas.toDataURL("image/png");
                // var a = document.createElement("a");
                // a.href = image;
                // console.log(a.href);
                var id = document.getElementById('app_id').value;
                $.ajax({
                    type: "POST",
                    url: '/patients/history-board/save',
                    data: {
                        _token:  "{{ csrf_token() }}",
                        id: id,
                        link: link.href
                    },
                    success: function (data) {
                        // console.log('true');
                        window.location.href = '/patients/' + data.id;
                    },
                    error: function (data) {
                        // console.log('false');
                    }
                });

                // a.download = "لوحة_الرسم.png";
                // document.body.appendChild(a);
                // a.click();
                // document.body.removeChild(a);
            });

            $(canvas).on("mousedown touchstart", startDrawing);
            $(canvas).on("mousemove touchmove", draw);
            $(canvas).on("mouseup touchend", stopDrawing);
            $(canvas).on("mouseleave touchcancel", stopDrawing);
        });
    </script>
</body>
</html>
