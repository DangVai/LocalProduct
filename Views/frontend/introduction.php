<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bru</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }

        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            color: #000;
            border: none;
            border-radius: 40px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            display: none;
        }
    </style>
</head>

<body>
    <video id="autoPlayVideo" autoplay loop muted>
        <source src="/localProducts/public/videos/6122180284134.mp4" type="video/mp4">
    </video>
    <button id="button" onclick="window.location.href='/localProducts/index.php?controller=user&action=forgot_password'">Go to home
        pages</button>
    <script>
        const video = document.getElementById('autoPlayVideo');
        video.play();

        video.addEventListener('click', () => {
            if (video.muted) {
                video.muted = false;
                video.play();
            }
        });

        // Hiển thị nút khi người dùng tương tác với video
        video.addEventListener('click', () => {
            document.getElementById('button').style.display = 'block';
            setTimeout(() => {
                document.getElementById('button').style.display = 'none';
            }, 5000);
        });

        // Hiển thị nút khi người dùng di chuột lên video
        video.addEventListener('mouseover', () => {
            document.getElementById('button').style.display = 'block';
            setTimeout(() => {
                document.getElementById('button').style.display = 'none';
            }, 3000);
        });

        document.getElementById('button').addEventListener('mouseover', () => {
            clearTimeout(timeout);
        });

        let timeout;
    </script>
</body>

</html>