<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartJob Demo</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap">
    <style>
        body {
            margin: 0;
            font-family: 'Sarabun', sans-serif;
            background-color: #f4f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .background-half-circle {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: url('<?= base_url('img/city-bg.jpg') ?>') no-repeat center center/cover;
            clip-path: ellipse(50% 100% at 50% 0%);
            z-index: -1;
            opacity: 0.28;
        }

        .login-container {
            display: flex;
            background: #fff;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.16);
            border-radius: 10px;
            overflow: hidden;
            width: min(80%, 1200px);
            z-index: 1;
        }

        .login-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #f8fafc;
        }

        .login-left img {
            width: 100%;
            height: 100%;
            max-height: 360px;
            border-radius: 10px;
            object-fit: cover;
        }

        .login-right {
            flex: 1;
            padding: 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
            color: #0f766e;
            font-weight: 700;
        }

        .brand img {
            width: 44px;
            height: 44px;
        }

        .login-right h2 {
            margin: 0 0 8px;
            font-size: 26px;
            color: #111827;
        }

        .login-right p {
            margin: 0 0 24px;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #374151;
        }

        .form-group input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #0f766e;
            color: white;
            border: none;
            padding: 12px 15px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #115e59;
        }

        @media (max-width: 820px) {
            .login-container {
                width: 92%;
                flex-direction: column;
            }

            .login-right {
                padding: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="background-half-circle"></div>
    <div class="login-container">
        <div class="login-left">
            <img src="<?= base_url('img/login-illustration.svg') ?>" alt="SmartJob Demo illustration">
        </div>
        <div class="login-right">
            <div class="brand">
                <img src="<?= base_url('img/brand-mark.svg') ?>" alt="SmartJob Demo logo">
                <span>SmartJob Demo</span>
            </div>
            <h2>เข้าสู่ระบบ</h2>
            <p>ระบบตัวอย่างสำหรับจัดการข้อมูลผู้สมัครงานและสถานประกอบการ</p>
            <form action="/authcontroller/loginauth" method="post">
                <div class="form-group">
                    <label for="username">ชื่อผู้ใช้งาน</label>
                    <input type="text" id="username" name="username" placeholder="กรอกชื่อผู้ใช้งาน">
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" id="password" name="password" placeholder="กรอกรหัสผ่าน">
                </div>
                <?php if (session()->getFlashdata('msg')): ?>
                    <div style="color: red; margin-bottom: 12px;"><?= session()->getFlashdata('msg') ?></div>
                <?php endif; ?>
                <button type="submit" class="btn">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>
</body>

</html>
