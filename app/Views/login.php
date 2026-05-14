<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smartjob</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap">
    <style>
        body {
            margin: 0;
            font-family: 'Sarabun', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            opacity: 0.5;
            /* ความโปร่งใส 50% */
        }

        .login-container {
            display: flex;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            width: 80%;
            max-width: 1200px;
            z-index: 1;
        }

        .login-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            width: 100%;
            height: 100%;
        }

        .login-left img {
            width: 100%;
            height: 100%;
            border-radius: 10px;
        }

        .login-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .extra-links {
            margin-top: 20px;
            text-align: center;
        }

        .extra-links a {
            color: #007bff;
            text-decoration: none;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="background-half-circle"></div>
    <div class="login-container">
        <div class="login-left">
            <img src="<?= base_url('img/loginlogo.png') ?>" alt="Smartjob">
        </div>
        <div class="login-right">
            <h2>เข้าสู่ระบบ - JobVista</h2>
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
                    <div style="color: red;"><?= session()->getFlashdata('msg') ?></div>
                <?php endif; ?>
                <button type="submit" class="btn">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>
</body>

</html>
