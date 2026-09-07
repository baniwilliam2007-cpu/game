<?php
session_start();

// Reset game
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: tebak.php");
    exit;
}

// Membuat angka rahasia hanya satu kali
if (!isset($_SESSION['angka'])) {
    $_SESSION['angka'] = rand(1, 5);
}

// Membuat penghitung percobaan
if (!isset($_SESSION['percobaan'])) {
    $_SESSION['percobaan'] = 0;
}

$angka_rahasia = $_SESSION['angka'];

$pesan = "";
$jenis_pesan = "";
$game_selesai = false;

// Memproses tebakan
if (isset($_POST['submit_tebakan'])) {

    if ($_SESSION['percobaan'] < 3) {

        $_SESSION['percobaan']++;

        $tebakan = $_POST['tebak'];

        // Tebakan benar
        if ($tebakan == $angka_rahasia) {

            $pesan = "🎉 JACKPOT! Tebakan kamu benar!";
            $jenis_pesan = "benar";
            $game_selesai = true;

        } else {

            // Game Over
            if ($_SESSION['percobaan'] >= 3) {

                $pesan = "🔴 GAME OVER! Kesempatan kamu sudah habis.";
                $jenis_pesan = "gameover";
                $game_selesai = true;

            } else {

                $pesan = "❌ Tebakan kamu salah! Coba lagi.";
                $jenis_pesan = "salah";
            }
        }

    } else {

        $pesan = "🔴 GAME OVER! Kesempatan kamu sudah habis.";
        $jenis_pesan = "gameover";
        $game_selesai = true;
    }
}

$percobaan = $_SESSION['percobaan'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Number Hunter</title>

    <style>

        body {
            margin: 0;
            padding: 0;

            font-family: Arial, sans-serif;

            background: linear-gradient(
                135deg,
                #09001a,
                #17002e,
                #001b33
            );

            color: white;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;
        }

        .container {

            width: 400px;

            padding: 35px;

            background: rgba(20, 20, 40, 0.9);

            border-radius: 20px;

            text-align: center;

            box-shadow: 0 0 30px #00ffff;
        }

        h1 {

            color: #00ffff;

            text-shadow: 0 0 10px #00ffff;
        }

        .target {

            font-size: 70px;

            margin: 20px 0;
        }

        p {

            color: #ddd;
        }

        .rules {

            background: rgba(0, 255, 255, 0.08);

            border: 1px solid #00ffff;

            padding: 15px;

            border-radius: 10px;

            margin: 20px 0;
        }

        .rules strong {

            color: #00ffff;
        }

        .form-tebakan {

            margin-top: 20px;
        }

        input {

            width: 80%;

            padding: 12px;

            border: 2px solid #00ffff;

            border-radius: 8px;

            background: #080812;

            color: white;

            font-size: 16px;

            text-align: center;

            outline: none;
        }

        input:focus {

            box-shadow: 0 0 15px #00ffff;
        }

        button {

            margin-top: 15px;

            padding: 12px 25px;

            border: none;

            border-radius: 8px;

            background: #00ffff;

            color: #000;

            font-weight: bold;

            cursor: pointer;

            box-shadow: 0 0 15px #00ffff;
        }

        button:hover {

            background: white;
        }

        .percobaan {

            margin-top: 20px;

            padding: 12px;

            border: 1px solid #00ffff;

            border-radius: 10px;

            color: #00ffff;

            font-weight: bold;

            background: rgba(0, 255, 255, 0.08);
        }

        .pesan {

            margin-top: 20px;

            padding: 15px;

            border-radius: 10px;

            font-weight: bold;
        }

        .pesan.benar {

            border: 2px solid #00ff88;

            color: #00ff88;

            background: rgba(0, 255, 136, 0.1);

            box-shadow: 0 0 15px #00ff88;
        }

        .pesan.salah {

            border: 2px solid #ff3366;

            color: #ff3366;

            background: rgba(255, 51, 102, 0.1);

            box-shadow: 0 0 15px #ff3366;
        }

        .pesan.gameover {

            border: 2px solid #ff0000;

            color: #ff4444;

            background: rgba(255, 0, 0, 0.1);

            box-shadow: 0 0 15px #ff0000;
        }

        .reset {

            margin-top: 15px;
        }

        .info {

            margin-top: 20px;

            color: #aaa;

            font-size: 14px;
        }

        footer {

            margin-top: 25px;

            font-size: 12px;

            color: #777;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>🎯 NUMBER HUNTER</h1>

    <div class="target">
        🎯
    </div>

    <p>
        Tebak angka rahasia dari <strong>1 sampai 5</strong>.
    </p>

    <div class="rules">

        <strong>📌 PERATURAN</strong>

        <br><br>

        Sistem telah memilih satu angka rahasia.

        <br>

        Kamu memiliki maksimal <strong>3 percobaan</strong>.

    </div>

    <?php if (!$game_selesai) { ?>

        <form method="post" class="form-tebakan">

            <input
                type="number"
                name="tebak"
                min="1"
                max="5"
                placeholder="Masukkan angka 1 - 5"
                required
            >

            <br>

            <button
                type="submit"
                name="submit_tebakan"
            >
                🔍 TEBAK SEKARANG
            </button>

        </form>

    <?php } ?>

    <div class="percobaan">

        🎲 Percobaan ke-<?php echo $percobaan; ?> dari 3

    </div>

    <?php if ($pesan != "") { ?>

        <div class="pesan <?php echo $jenis_pesan; ?>">

            <?php echo $pesan; ?>

        </div>

    <?php } ?>


    <?php if ($game_selesai) { ?>

        <form method="post" class="reset">

            <button
                type="submit"
                name="reset"
            >
                🔄 MAIN LAGI
            </button>

        </form>

    <?php } ?>


    <div class="info">

        🔐 Angka rahasia telah dibuat oleh sistem.

    </div>

    <footer>

        NUMBER HUNTER © 2026

    </footer>

</div>

</body>

</html>