<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faylni Yuklash</title>
</head>
<body>
    <h1></h1>

    <!-- Formani o‘zgartirish -->
    <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Faylni tanlash -->
        <label for="file">Faylni tanlang:</label>
        <input type="file" name="file" id="file" required>

        <br>

        <!-- Konvertatsiya turini tanlash -->
        <label for="conversion_type">Konvertatsiya turi:</label>
        <input type="radio" name="conversion_type" value="latin_to_cyrillic" checked> Lotindan Kirilga
        <input type="radio" name="conversion_type" value="cyrillic_to_latin"> Kirildan Lotinga

        <br>

        <button type="submit">Yuklash</button>
    </form>

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
</body>
</html>
