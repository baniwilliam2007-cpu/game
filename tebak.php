<?php
session_start();

// Membuat angka rahasia hanya sekali
if (!isset($_SESSION['angka'])) {
    $_SESSION['angka'] = rand(1, 5);
    $_SESSION['percobaan'] = 0;
}

$x = $_SESSION['angka'];
$pesan = "";
$jenis_pesan = "";

if (isset($_POST['tebak'])) {

    $_SESSION['percobaan']++;

    $tebakan = $_POST['tebak'];
    $percobaan = $_SESSION['percobaan'];

    if ($tebakan == $x) {

        $pesan = "🎉 <strong>JACKPOT!</strong><br>
                  Tebakan kamu benar!<br>
                  Angka rahasianya adalah <strong>$x</strong>";
        $jenis_pesan = "benar";

        // Reset game
        unset($_SESSION['angka']);
        unset($_SESSION['percobaan']);

    } elseif ($percobaan >= 3) {

        $pesan = "💀 <strong>GAME OVER!</strong><br>
                  Kesempatan kamu sudah habis.<br>
                  Angka yang benar adalah <strong>$x</strong>";
        $jenis_pesan = "salah";

        // Reset game
        unset($_SESSION['angka']);
        unset($_SESSION['percobaan']);

    } else {

        $sisa = 3 - $percobaan;

        $pesan = "⚡ <strong>TEBAKAN SALAH!</strong><br>
                  Masih ada <strong>$sisa kesempatan</strong>.";
        $jenis_pesan = "salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Number Hunter</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background:
                radial-gradient(circle at top, #1f2937 0%, #09090b 45%, #020617 100%);

            color: white;

            overflow: hidden;
        }

        /* Efek lingkaran background */

        body::before {

            content: "";

            position: absolute;

            width: 500px;

            height: 500px;

            background: #00f5ff;

            opacity: 0.08;

            border-radius: 50%;

            filter: blur(100px);

            top: -150px;

            left: -150px;
        }

        body::after {

            content: "";

            position: absolute;

            width: 500px;

            height: 500px;

            background: #a855f7;

            opacity: 0.08;

            border-radius: 50%;

            filter: blur(100px);

            bottom: -150px;

            right: -150px;
        }

        .container {

            position: relative;

            z-index: 2;

            width: 420px;

            padding: 35px;

            border-radius: 25px;

            background: rgba(15, 23, 42, 0.92);

            border: 1px solid rgba(0, 245, 255, 0.3);

            box-shadow:
                0 0 20px rgba(0, 245, 255, 0.15),
                0 0 60px rgba(168, 85, 247, 0.12);

            text-align: center;
        }

        .icon {

            width: 90px;

            height: 90px;

            margin: 0 auto 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: linear-gradient(
                135deg,
                #00f5ff,
                #8b5cf6
            );

            font-size: 45px;

            box-shadow:
                0 0 20px rgba(0, 245, 255, 0.5),
                0 0 40px rgba(139, 92, 246, 0.3);
        }

        h1 {

            font-size: 30px;

            margin-bottom: 8px;

            color: #ffffff;

            letter-spacing: 2px;

            text-shadow:
                0 0 10px rgba(0, 245, 255, 0.8);
        }

        .subtitle {

            color: #94a3b8;

            font-size: 14px;

            margin-bottom: 25px;
        }

        .aturan {

            background: rgba(30, 41, 59, 0.8);

            border: 1px solid rgba(148, 163, 184, 0.15);

            border-radius: 15px;

            padding: 18px;

            margin-bottom: 22px;

            text-align: left;

            color: #cbd5e1;

            font-size: 14px;

            line-height: 1.8;
        }

        .aturan strong {

            color: #00f5ff;

            font-size: 15px;
        }

        .number-box {

            position: relative;

            margin-bottom: 15px;
        }

        input {

            width: 100%;

            padding: 15px;

            border-radius: 12px;

            border: 1px solid #334155;

            background: #020617;

            color: white;

            font-size: 18px;

            text-align: center;

            outline: none;

            transition: 0.3s;
        }

        input::placeholder {

            color: #64748b;
        }

        input:focus {

            border-color: #00f5ff;

            box-shadow:
                0 0 10px rgba(0, 245, 255, 0.4);
        }

        button {

            width: 100%;

            padding: 15px;

            border: none;

            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #00f5ff,
                #8b5cf6
            );

            color: #020617;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;

            box-shadow:
                0 0 15px rgba(0, 245, 255, 0.25);
        }

        button:hover {

            transform: translateY(-2px);

            box-shadow:
                0 0 25px rgba(0, 245, 255, 0.5);
        }

        button:active {

            transform: scale(0.98);
        }

        .hasil {

            margin-top: 20px;

            padding: 17px;

            border-radius: 14px;

            line-height: 1.7;

            font-size: 14px;
        }

        .benar {

            background: rgba(34, 197, 94, 0.12);

            border: 1px solid #22c55e;

            color: #86efac;

            box-shadow:
                0 0 15px rgba(34, 197, 94, 0.15);
        }

        .salah {

            background: rgba(239, 68, 68, 0.12);

            border: 1px solid #ef4444;

            color: #fca5a5;

            box-shadow:
                0 0 15px rgba(239, 68, 68, 0.15);
        }

        .footer {

            margin-top: 25px;

            color: #475569;

            font-size: 12px;

            letter-spacing: 1px;
        }

        .badge {

            display: inline-block;

            margin-top: 12px;

            padding: 5px 12px;

            border-radius: 20px;

            background: rgba(0, 245, 255, 0.08);

            border: 1px solid rgba(0, 245, 255, 0.2);

            color: #67e8f9;

            font-size: 11px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="icon">
        🎯
    </div>

    <h1>NUMBER HUNTER</h1>

    <p class="subtitle">
        Temukan angka rahasia dan menangkan permainan!
    </p>

    <div class="aturan">

        <strong>⚡ MISSION RULES</strong>

        <br>

        🎯 Angka rahasia berada di antara <strong>1 - 5</strong>

        <br>

        🔥 Kamu memiliki <strong>3 kesempatan</strong>

        <br>

        🧠 Gunakan strategi terbaikmu

        <br>

        💎 Berhasil menebak = <strong>WIN!</strong>

    </div>

    <form method="post">

        <div class="number-box">

            <input
                type="number"
                name="tebak"
                min="1"
                max="5"
                placeholder="Masukkan angka 1 - 5"
                required
            >

        </div>

        <button type="submit">
            🚀 SUBMIT GUESS
        </button>

    </form>

    <?php if ($pesan != "") { ?>

        <div class="hasil <?php echo $jenis_pesan; ?>">

            <?php echo $pesan; ?>

        </div>

    <?php } ?>

    <div class="badge">
        PHP • NUMBER HUNTER • GAME
    </div>

    <div class="footer">

        © 2026 Number Hunter

    </div>

</div>

</body>

</html>