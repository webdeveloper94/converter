<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Converter</title>
    <link rel="stylesheet" href="css/upload.css">
    <style>
        body, html {
          margin: 0;
  padding: 0;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.3);
        }
        canvas {
            position: absolute; /* Position canvas absolutely */
            top: 0;
            left: 0;
            z-index: -1; /* Sends canvas behind content */
        }
        
    </style>
</head>
<body>
  <canvas id="embersCanvas"></canvas>
  <div class="container">
    <header>
      <h4>Word va excel hujjatlaringizni soniyalar ichida krildan lotinga yoki lotindan krilga o'zgartiring</h4>
    </header>

    <section class="converter">
      <h2>Excel yoki word faylni yuklang va o'girish kerak bo'lgan tilni tanlang</h2>
      <div class="centered">
      <div class="upload-section">
     <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
      @csrf
          <input type="file" id="file-upload" name="file" required/>
          <label for="file-upload">Faylni tanlang</label>
        <div class="file-name" id="file-name"></div>
        <select id="language-select" name="conversion_type">
            <option value="latin_to_cyrillic">Lotindan krilga</option>
            <option value="cyrillic_to_latin">Krildan lotinga</option>
        </select>
        <input type="submit" value="O'girish" class="translate-btn">
     </form>
     
      </div>
      
      </div>
      <br><br>
      {{-- Yuklab olish tugmasi --}}
      @if (session('success'))
     <div class="alert alert-success">
        <h2> {{ session('success') }}</h2>
     </div>
 @endif
 <br>
 
 @if (session('download_link') && session('auto_download'))
     <a href="{{ session('download_link') }}" class="download-btn" download>Yuklab olish</a>
 @endif 
      <br><br>
      <p class="note">Matnni yozing va oson konvertatsiya qiling</p>

      <div class="text-conversion">
        <select id="text-language-select-1">
            <option value="latin">Latin</option>
            <option value="cyrillic">Cyrillic</option>
        </select>
    
        <button class="swap-btn">⇆</button>
    
        <select id="text-language-select-2"> 
            <option value="cyrillic">Cyrillic</option>
            <option value="latin">Latin</option>
        </select>
    
        <textarea id="input-text" placeholder="Matnni yozing"></textarea>
        <textarea id="output-text" placeholder="" disabled></textarea>
    
        <button class="translate-btn">Translate</button>
    </div>
    
    
    </section>

    <footer>
      <p>Conversion from Latin to Kiril or from Cyrillic to Latin</p>
      <p>Translation from Latin to Cyrillic and vice versa...<br>Our service offers professional translation of documents...</p>
      <nav>
        <a href="#">Main</a>
        <a href="#">Donate</a>
        <a href="#">Keyboard</a>
        <a href="#">Bot</a>
        <a href="#">FAQ</a>
        <a href="#">Contact us</a>
      </nav>
    </footer>
  </div>
</body>
<script src="js/canvas.js"></script>




</html>
