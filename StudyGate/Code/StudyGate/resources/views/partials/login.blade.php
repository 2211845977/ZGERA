<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Montserrat:wght@700,800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        }

        .login-container {
            height: 100vh;
            display: flex;
            align-items: stretch;
            box-shadow: 0 15px 30px rgba(44, 8, 203, 0.1);
        }

        .image-section {
            flex: 1;
            background: #070e74;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.1) 75%, transparent 75%, transparent);
            background-size: 100px 100px;
            opacity: 0.1;
            animation: moveBackground 30s linear infinite;
        }

        @keyframes moveBackground {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 100px 100px;
            }
        }

        .decoration-circles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .decoration-circles circle {
            fill: none;
            stroke: rgba(255, 255, 255, 0.1);
            stroke-width: 2px;
        }

        .form-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            order: 1;
            background: white;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }

        .logo {
            font-size: 4rem;
            margin-bottom: 2rem;
            font-weight: 800;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            white-space: nowrap;
        }

        .logo span:first-child {
            background: linear-gradient(45deg, #0061f2, #0056d6);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo span:last-child {
            background: linear-gradient(45deg, #00a3f9, #00c6f9);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            margin-left: 15px;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1.25rem 0.75rem 2.5rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: #0061f2;
            box-shadow: 0 0 0 0.2rem rgba(0, 97, 242, 0.1);
            background-color: white;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, #0061f2, #00c6f9);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 97, 242, 0.3);
        }

        .form-check-input:checked {
            background-color: #0061f2;
            border-color: #0061f2;
        }

        .form-check-label {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- القسم الأيمن للرسم التوضيحي -->
        <div class="image-section">
            <div style="position: relative; width: 400px; height: 400px;">
                <!-- Large Graduation Cap Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 300px; height: 300px; position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%);">
                    <path fill="rgba(255,255,255,1)" d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496 288 320 367.6 144 288V408z" />
                </svg>

                <!-- Animated Text -->
                <div class="tagline" style="position: absolute; width: 100%; text-align: center; top: 85%; left: 50%; transform: translate(-50%, -50%); color: white; font-family: 'Montserrat', sans-serif; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                    <div style="font-size: 1.5rem; opacity: 0; animation: fadeInUp 1.5s ease-out forwards; font-weight: 300; letter-spacing: 1px;">
                        Your smart gateway
                    </div>
                    <div style="font-size: 1.5rem; opacity: 0; animation: fadeInUp 1.5s ease-out 0.5s forwards; font-weight: 600; background: linear-gradient(to right, #ffffff, #e0e0e0); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: none;">
                        to academic success
                    </div>
                </div>

                <!-- Background Circles with Animation -->
                <svg class="decoration-circles" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0;">
                    <circle cx="80" cy="80" r="8" fill="rgba(255,255,255,0.2)">
                        <animate attributeName="r" values="8;12;8" dur="3s" repeatCount="indefinite" />
                    </circle>
                    <circle cx="20" cy="20" r="6" fill="rgba(255,255,255,0.2)">
                        <animate attributeName="r" values="6;10;6" dur="3s" repeatCount="indefinite" />
                    </circle>
                    <circle cx="80" cy="20" r="4" fill="rgba(255,255,255,0.2)">
                        <animate attributeName="r" values="4;8;4" dur="3s" repeatCount="indefinite" />
                    </circle>
                </svg>
            </div>
            </svg>
        </div>

        <!-- قسم النموذج -->
        <div class="form-section">
            <div class="form-container">
                <div class="logo"><span>Study</span><span>Gate</span></div>

   <form method="POST" action="{{ route('login') }}">
    @csrf

    <h5 class="text-center mb-4" style="color: #495057;">تسجيل الدخول إلى حسابك</h5>

    <div class="mb-3">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <div class="input-group">
            <i class="fas fa-user input-icon"></i>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   placeholder="أدخل البريد الإلكتروني" 
                   required 
                   autofocus>
        </div>
        @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">كلمة المرور</label>
        <div class="input-group">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   placeholder="أدخل كلمة المرور" 
                   required>
        </div>
        @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">تذكرني</label>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary px-5">تسجيل الدخول</button>
    </div>
</form>

            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>