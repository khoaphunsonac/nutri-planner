<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đặt lại mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fffcf4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background-color: #f8a13c;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .btn {
            display: inline-block;
            background-color: #f8a13c;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🔐 Đặt Lại Mật Khẩu</h2>
            <p>Nutri-Planner</p>
        </div>
        
        <div class="content">
            <h3 style="color: #f57c00;">Xin chào!</h3>
            
            <p>Bạn nhận được email này vì có yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
            
            <p>Nhấn vào nút bên dưới để đặt lại mật khẩu:</p>
            
            <div style="text-align: center;">
                <a href="{{ $link }}" class="btn">
                    🔑 Đặt Lại Mật Khẩu
                </a>
            </div>
            
            <p style="font-size: 14px; color: #6c757d; margin-top: 20px;">
                Hoặc copy link này vào trình duyệt:<br>
                <a href="{{ $link }}" style="color: #f8a13c; word-break: break-all;">{{ $link }}</a>
            </p>
            
            <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <strong>⚠️ Lưu ý:</strong> Link này sẽ hết hạn sau 60 phút.
            </div>
            
            <p style="color: #6c757d;">
                Nếu bạn không yêu cầu đặt lại mật khẩu, hãy bỏ qua email này. 
                Tài khoản của bạn vẫn an toàn.
            </p>
        </div>
        
        <div class="footer">
            <p><strong>Trân trọng,</strong></p>
            <p>Đội ngũ hỗ trợ Nutri-Planner</p>
            <hr style="border: none; border-top: 1px solid #dee2e6; margin: 15px 0;">
            <p style="font-size: 12px;">
                © 2024 Nutri-Planner. Tất cả quyền được bảo lưu.<br>
                Email này được gửi tự động, vui lòng không phản hồi.
            </p>
        </div>
    </div>
</body>
</html>