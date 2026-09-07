<?php
session_start();

// ==============================
// RESET GAME
// ==============================

if (isset($_POST['reset'])) {

    session_destroy();

    header("Location: tebak.php");

    exit;
}


// ==============================
// INISIALISASI GAME
// ==============================

if (!isset($_SESSION['angka'])) {

    $_SESSION['angka'] = rand(1, 5);
}


if (!isset($_SESSION['percobaan'])) {

    $_SESSION['percobaan'] = 0;
}


$angka_rahasia = $_SESSION['angka'];

$pesan = "";

$jenis_pesan = "";

$game_selesai = false;


// ==============================
// PROSES TEBAKAN
// ==============================

if (isset($_POST['submit_tebakan'])) {

    if ($_SESSION['percobaan'] < 3) {

        $tebakan = (int) $_POST['tebak'];


        // Validasi angka
        if ($tebakan < 1 || $tebakan > 5) {

            $pesan = "⚠️ Masukkan angka antara 1 sampai 5.";

            $jenis_pesan = "salah";

        } else {

            // Menambah percobaan
            $_SESSION['percobaan']++;


            // Mengecek jawaban
            if ($tebakan == $angka_rahasia) {

                $pesan =
                    "🎉 JACKPOT! Tebakan kamu benar!";

                $jenis_pesan = "benar";

                $game_selesai = true;

            } else {

                // Mengecek Game Over
                if ($_SESSION['percobaan'] >= 3) {

                    $pesan =
                        "🔴 GAME OVER! Kesempatan kamu sudah habis.";

                    $jenis_pesan = "gameover";

                    $game_selesai = true;

                } else {

                    $sisa =
                        3 - $_SESSION['percobaan'];

                    $pesan =
                        "❌ Tebakan kamu salah! " .
                        "Masih ada " .
                        $sisa .
                        " kesempatan.";

                    $jenis_pesan = "salah";
                }
            }
        }

    } else {

        $pesan =
            "🔴 GAME OVER! Kesempatan kamu sudah habis.";

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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Number Hunter</title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            padding: 20px;

            font-family: Arial, sans-serif;

            background:
                radial-gradient(
                    circle at top,
                    #18205c,
                    transparent 40%
                ),
                linear-gradient(
                    135deg,
                    #05000d,
                    #10001f,
                    #00182d
                );

            color: white;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;
        }


        .container {

            width: 430px;

            padding: 40px 35px;

            background: rgba(10, 15, 35, 0.94);

            border: 1px solid rgba(0, 255, 255, 0.5);

            border-radius: 25px;

            text-align: center;

            box-shadow:
                0 0 20px rgba(0, 255, 255, 0.4),
                0 0 60px rgba(0, 255, 255, 0.15);

            backdrop-filter: blur(10px);
        }


        h1 {

            margin: 0;

            color: #00ffff;

            font-size: 30px;

            letter-spacing: 2px;

            text-shadow:
                0 0 8px #00ffff,
                0 0 20px #00ffff;
        }


        .target {

            font-size: 75px;

            margin: 25px 0;

            filter:
                drop-shadow(0 0 10px #00ffff);
        }


        p {

            color: #d5d5d5;

            line-height: 1.6;
        }


        p strong {

            color: #00ffff;
        }


        .rules {

            margin: 25px 0;

            padding: 18px;

            border-radius: 15px;

            background: rgba(0, 255, 255, 0.06);

            border: 1px solid rgba(0, 255, 255, 0.5);

            line-height: 1.6;

            color: #ddd;
        }


        .rules strong {

            color: #00ffff;

            letter-spacing: 1px;
        }


        .form-tebakan {

            margin-top: 25px;
        }


        input {

            width: 100%;

            padding: 14px;

            border: 2px solid #00ffff;

            border-radius: 12px;

            background: #05050d;

            color: white;

            font-size: 17px;

            text-align: center;

            outline: none;

            transition: 0.3s;
        }


        input:focus {

            border-color: white;

            box-shadow:
                0 0 10px #00ffff,
                0 0 25px rgba(0, 255, 255, 0.4);
        }


        button {

            margin-top: 17px;

            padding: 14px 28px;

            border: none;

            border-radius: 12px;

            background: #00ffff;

            color: #001010;

            font-size: 15px;

            font-weight: bold;

            letter-spacing: 1px;

            cursor: pointer;

            transition: 0.3s;

            box-shadow:
                0 0 10px #00ffff,
                0 0 25px rgba(0, 255, 255, 0.4);
        }


        button:hover {

            transform: translateY(-2px);

            background: white;

            box-shadow:
                0 0 15px white,
                0 0 30px #00ffff;
        }


        .percobaan {

            margin-top: 25px;

            padding: 13px;

            border-radius: 12px;

            background: rgba(0, 255, 255, 0.07);

            border: 1px solid rgba(0, 255, 255, 0.4);

            color: #00ffff;

            font-weight: bold;
        }


        .pesan {

            margin-top: 20px;

            padding: 16px;

            border-radius: 12px;

            font-weight: bold;

            line-height: 1.5;
        }


        .pesan.benar {

            color: #00ff88;

            border: 2px solid #00ff88;

            background: rgba(0, 255, 136, 0.08);

            box-shadow:
                0 0 20px rgba(0, 255, 136, 0.35);
        }


        .pesan.salah {

            color: #ff4f81;

            border: 2px solid #ff4f81;

            background: rgba(255, 79, 129, 0.08);

            box-shadow:
                0 0 20px rgba(255, 79, 129, 0.25);
        }


        .pesan.gameover {

            color: #ff4444;

            border: 2px solid #ff3333;

            background: rgba(255, 0, 0, 0.08);

            box-shadow:
                0 0 20px rgba(255, 0, 0, 0.3);
        }


        .reset {

            margin-top: 5px;
        }


        .reset button {

            background: #ffcc00;

            color: #111;

            box-shadow:
                0 0 10px #ffcc00,
                0 0 20px rgba(255, 204, 0, 0.3);
        }


        .reset button:hover {

            background: white;
        }


        .info {

            margin-top: 25px;

            color: #888;

            font-size: 13px;
        }


        footer {

            margin-top: 25px;

            padding-top: 20px;

            border-top:
                1px solid
                rgba(255, 255, 255, 0.08);

            color: #555;

            font-size: 12px;

            letter-spacing: 1px;
        }


        @media (max-width: 500px) {

            .container {

                width: 100%;

                padding: 30px 20px;
            }


            h1 {

                font-size: 25px;
            }
        }

    </style>

</head>


<body>

<div class="container">


    <h1>
        🎯 NUMBER HUNTER
    </h1>


    <div class="target">
        🎯
    </div>


    <p>

        Tebak angka rahasia dari
        <strong>1 sampai 5</strong>.

    </p>


    <div class="rules">

        <strong>
            📌 PERATURAN
        </strong>

        <br><br>

        Sistem telah memilih satu angka rahasia.

        <br>

        Kamu memiliki maksimal
        <strong>3 percobaan</strong>.

    </div>


    <?php if (!$game_selesai) { ?>

        <form
            method="post"
            class="form-tebakan"
        >

            <input
                type="number"
                name="tebak"
                min="1"
                max="5"
                placeholder="Masukkan angka 1 - 5"
                required
            >


            <button
                type="submit"
                name="submit_tebakan"
            >

                🔍 TEBAK SEKARANG

            </button>

        </form>

    <?php } ?>


    <div class="percobaan">

        🎲 Percobaan ke-<?php
        echo $percobaan;
        ?> dari 3

    </div>


    <?php if ($pesan != "") { ?>

        <div
            class="pesan <?php
            echo $jenis_pesan;
            ?>"
        >

            <?php
            echo $pesan;
            ?>

        </div>

    <?php } ?>


    <?php if ($game_selesai) { ?>

        <form
            method="post"
            class="reset"
        >

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