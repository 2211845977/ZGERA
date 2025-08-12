<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - ادارة المختبرات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to left, #4e54c8, #8f94fb);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            margin-bottom: 25px;
            text-align: center;
            color: #4e54c8;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: #4e54c8;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .actions a {
            color: #4e54c8;
            text-decoration: none;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #4e54c8;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-btn:hover {
            background: #3b3fc4;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .footer a {
            color: #8f94fb;
            text-decoration: none;
            font-weight: bold;
        }

        .alert {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>تسجيل الدخول</h2>
        @if(session('error'))
        <div class="alert">{{ session('error') }}</div>
        @endif
        @if($errors->any())
        <div class="alert">
            {{ $errors->first() }}
        </div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" placeholder="ادخل بريدك" required value="{{ old('email') }}">
            </div>

            <div class="input-group">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password" placeholder="ادخل كلمة المرور" required>
            </div>

            <div class="actions">
                <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> تذكرني</label>
            </div>

            <button class="login-btn" type="submit">دخول</button>
        </form>

    </div>

</body>

</html>