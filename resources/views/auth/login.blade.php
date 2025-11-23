<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UMKM Fotografi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://example.com/sample-photo1.jpg') no-repeat center center fixed,
                        url('https://example.com/sample-photo2.jpg') no-repeat 20% 20% fixed,
                        url('https://example.com/sample-photo3.jpg') no-repeat 80% 80% fixed;
            background-size: cover;
            filter: blur(5px);
            z-index: -1;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Overlay gelap untuk kontras */
            z-index: -1;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        h2 {
            color: #8B4513; /* Warna coklat untuk nuansa UMKM */
            margin-bottom: 20px;
            font-size: 2em;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            background: rgba(255, 255, 255, 0.8);
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #8B4513;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #A0522D;
            transform: translateY(-2px);
        }
        .logo {
            margin-bottom: 20px;
        }
        .logo img {
            width: 80px;
            height: auto;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .photo-thumbnails {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .photo-thumbnails img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .photo-thumbnails img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="overlay"></div>
    <div class="login-container">
        <div class="logo">
            <!-- Ganti dengan logo UMKM fotografi Anda -->
            <img src="https://example.com/camera-logo.png" alt="Logo UMKM Fotografi">
        </div>
        <h2>Login ke UMKM Fotografi</h2>

        @if(session()->has('loginError'))
            <p class="error">{{ session('loginError') }}</p>
        @endif

        <form action="/login" method="POST">
            @csrf
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>

        <!-- Thumbnail gambar hasil foto untuk nuansa -->
        <div class="photo-thumbnails">
            <img src="https://example.com/thumbnail1.jpg" alt="Foto 1">
            <img src="https://example.com/thumbnail2.jpg" alt="Foto 2">
            <img src="https://example.com/thumbnail3.jpg" alt="Foto 3">
        </div>
    </div>
</body>
</html>
