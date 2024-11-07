<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/canvas.css">
    <link rel="stylesheet" href="css/upload.css">
  
</head>
<body>
    <!-- Content joylashtirish -->
    <div class="content">
        <h3>Ofis fayllar bilan ishlash uchun kerak bo'lgan har bir vosita bir joyda</h3>
        <p>Word va excel hujjatlaringizni krildan lotinga va lotindan krilga soniyalar ichida o'zgartiring</p>
         {{-- fayl yuklash --}}
         <div class="container">
            <div class="center-box">
              <div class="upload-box noselect">
                <div class="upload-file">
                <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" id="file">
                
                  <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI5NC4xNTYgMjk0LjE1NiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjk0LjE1NiAyOTQuMTU2OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCI+CjxnPgoJPHBhdGggZD0iTTIyNy4wMDIsMTA4LjI1NmMtMi43NTUtNDEuNzUxLTM3LjYtNzQuODc4LTgwLjAzNi03NC44NzhjLTQyLjQ0NywwLTc3LjI5OCwzMy4xNDEtODAuMDM4LDc0LjkwNyAgIEMyOC45NzgsMTEzLjA1OSwwLDE0NS4zOSwwLDE4NC4xODRjMCw0Mi4yMzQsMzQuMzYsNzYuNTk1LDc2LjU5NSw3Ni41OTVoMTE2LjQ4M2MzLjMxMywwLDYtMi42ODcsNi02cy0yLjY4Ny02LTYtNkg3Ni41OTUgICBDNDAuOTc3LDI0OC43NzgsMTIsMjE5LjgwMSwxMiwxODQuMTg0YzAtMzQuMjc1LDI2LjgzMy02Mi41NjgsNjEuMDg3LTY0LjQxMWMzLjE4NC0wLjE3MSw1LjY3OC0yLjgwMyw1LjY3OC01Ljk5MSAgIGMwLTAuMTE5LTAuMDAzLTAuMjM2LTAuMDEtMC4zNTVjMC4wOS0zNy41MzYsMzAuNjU0LTY4LjA0OSw2OC4yMTEtNjguMDQ5YzM3LjU2MywwLDY4LjEzMiwzMC41MTgsNjguMjExLDY4LjA2MyAgIGMtMC4wMDUsMC4xMTYtMC4wMDksMC4yMzgtMC4wMDksMC4zMjljMCwzLjE5NiwyLjUwNSw1LjgzMSw1LjY5Niw1Ljk5MmMzNC4zNywxLjc0MSw2MS4yOTIsMzAuMDM4LDYxLjI5Miw2NC40MjEgICBjMCwxOS41MjYtOC42OTgsMzcuODAxLTIzLjg2NCw1MC4xMzhjLTIuNTcxLDIuMDkxLTIuOTU5LDUuODctMC44NjgsOC40NGMyLjA5MSwyLjU3MSw1Ljg3LDIuOTU5LDguNDQsMC44NjggICBjMTcuOTgtMTQuNjI2LDI4LjI5Mi0zNi4yOTMsMjguMjkyLTU5LjQ0N0MyOTQuMTU2LDE0NS4yNjksMjY1LjA4LDExMi45MjYsMjI3LjAwMiwxMDguMjU2eiIgZmlsbD0iIzQxNTE2YiIvPgoJPHBhdGggZD0iTTE0MC45NjYsMTQxLjA3OHY3Ni41MTFjMCwzLjMxMywyLjY4Nyw2LDYsNnM2LTIuNjg3LDYtNnYtNzYuNTExYzAtMy4zMTMtMi42ODctNi02LTZTMTQwLjk2NiwxMzcuNzY1LDE0MC45NjYsMTQxLjA3OHoiIGZpbGw9IiM0MTUxNmIiLz4KCTxwYXRoIGQ9Ik0xODEuMjgzLDE1Mi4yMDRjMS41MzYsMCwzLjA3MS0wLjU4Niw0LjI0My0xLjc1N2MyLjM0My0yLjM0MywyLjM0My02LjE0MiwwLTguNDg1bC0zNC4zMTctMzQuMzE3ICAgYy0yLjM0My0yLjM0My02LjE0My0yLjM0My04LjQ4NSwwbC0zNC4zMTcsMzQuMzE3Yy0yLjM0MywyLjM0My0yLjM0Myw2LjE0MiwwLDguNDg1YzIuMzQzLDIuMzQzLDYuMTQzLDIuMzQzLDguNDg1LDAgICBsMzAuMDc0LTMwLjA3NGwzMC4wNzQsMzAuMDc0QzE3OC4yMTIsMTUxLjYxOCwxNzkuNzQ4LDE1Mi4yMDQsMTgxLjI4MywxNTIuMjA0eiIgZmlsbD0iIzQxNTE2YiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
                  <h6>Faylni yuklash</h6>
                </div>
                <div class="upload-details">
                  <ul>
                    <li id="step1"><i class="fa fa-upload"></i>
          <p>Fayl tekshirilyapti<small>Matnlar o'qilyapti</small></p></li>
                    <li id="step2"><i class="fa fa-cog"></i>
          <p>Fayl yuklanyapti <small>Fayl o'qildi</small></p></li>
                    <li id="step3"><i class="fa fa-download"></i><p>Fayl tasdiqlandi<small>Fayl yuklandi</small></p></li>
                  </ul>
                </div>
                
              </div>
              
              <div class="shadow">
                <label for="conversion_type">Konvertatsiya turi:</label>
          <input type="radio" name="conversion_type" value="latin_to_cyrillic" checked> Lotindan Kirilga
          <input type="radio" name="conversion_type" value="cyrillic_to_latin"> Kirildan Lotinga
          <button type="submit">Yuklash</button>
              </div>
              @if (session('success'))
    <div>
        <p>{{ session('success') }}</p>
        @if(session('download_link'))
            <a href="{{ session('download_link') }}" download>Yuklab olish</a>
        @elseif(session('converted_text'))
            <textarea readonly>{{ session('converted_text') }}</textarea>
        @endif
    </div>
@endif
            </div>
          </div>
          
        </form>

        
         {{-- Fayl yuklash tugashi --}}
    </div>

    <!-- Canvas element -->
    <canvas id="embersCanvas"></canvas>
    
    <script src="js/canvas.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
       $("#file").change(function(){
  var file = document.getElementById('file').files[0];
  //console.log(ext);
  
  //if(file['size'] !== 262144 && file['size'] !== 262144 * 2 && file['name'].split('.').pop() !== 'rom'){
  if(1 == 2){
    alert('BIOS file mistmatch!');
  } else {
    $(".upload-file").addClass('animate-flicker');
    $(".upload-file h6").text('Fayl tekshirilyapti');
    $("#step1 p").addClass('ready');
    $("#step1 i").addClass('ready');
    $("#step1 i.fa-upload").removeClass('fa-upload').addClass('fa-check');
    setTimeout(function(){
      $("#step2 p").addClass('ready');
    }, 1000);
    setTimeout(function(){
      $(".upload-details p").addClass('ready');
      $(".upload-details i").addClass('ready');
      $(".upload-file").removeClass('animate-flicker');
      $(".upload-file h6").text('Fayl yuklandi');    
      $(".fa-upload").removeClass('fa-upload').addClass('fa-check');
      $(".fa-cog").removeClass('fa-cog').addClass('fa-check');
      $(".fa-download").removeClass('fa-download').addClass('fa-check');
    }, 5000);
  }
});


    </script>
</body>
</html>
