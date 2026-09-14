<?php
session_start();
include("../config/connexion.php");

$erreur = "";

if (isset($_POST['connecter'])) {

    $login = trim($_POST['login']);
    $motDePasse = $_POST['motDePasse'];

    // Requête préparée pour éviter les injections SQL
    $stmt = mysqli_prepare(
        $connexion,
        "SELECT * FROM utilisateur WHERE login = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

        $utilisateur = mysqli_fetch_assoc($result);

        if (password_verify($motDePasse, $utilisateur['motDePasse'])) {

            $_SESSION['utilisateur'] = $utilisateur['login'];
            $_SESSION['role'] = $utilisateur['role'];
            $_SESSION['idUtilisateur'] = $utilisateur['idUtilisateur'];

            header("Location: ../dashboard.php");
            exit();

        } else {
            $erreur = "Login ou mot de passe incorrect.";
        }

    } else {
        $erreur = "Login ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Connexion - NetModern</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- CSS NetModern -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/modern.css">

    <style>

        body {
            margin: 0;
            min-height: 100vh;
            background: #f4f7fc;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
        }

        /* ============================= */
        /* PARTIE GAUCHE                 */
        /* ============================= */

        .login-left {
            width: 45%;
            min-height: 100vh;
            background: #0d1930;
            padding: 60px;
            color: white;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .login-logo-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;

            display: flex;
            justify-content: center;
            align-items: center;

            background: linear-gradient(135deg, #1685ff, #14b8d4);

            font-size: 26px;
            color: white;

            box-shadow: 0 10px 30px rgba(22, 133, 255, .25);
        }

        .login-logo h2 {
            margin: 0;
            color: white;
            font-size: 27px;
            font-weight: 800;
        }

        .login-logo span {
            color: #8194b4;
            font-size: 14px;
        }

        .login-presentation {
            max-width: 520px;
        }

        .login-small-title {
            color: #2791ff;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .login-presentation h1 {
            color: white;
            font-size: 52px;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 25px;
        }

        .login-presentation p {
            color: #a8b5ca;
            font-size: 18px;
            line-height: 1.8;
        }

        .login-features {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }

        .login-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #c9d3e2;
            font-size: 14px;
        }

        .login-feature i {
            color: #2991ff;
        }

        .login-copyright {
            color: #647792;
            font-size: 13px;
        }


        /* ============================= */
        /* PARTIE DROITE                 */
        /* ============================= */

        .login-right {
            width: 55%;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 50px;
        }

        .login-container {
            width: 100%;
            max-width: 520px;
        }

        .login-security-icon {
            width: 75px;
            height: 75px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 20px;

            background: #e8f3ff;
            color: #1685ff;

            font-size: 30px;

            margin-bottom: 30px;
        }

        .login-container h2 {
            color: #0c1730;
            font-size: 38px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: #7d8eaa;
            font-size: 17px;
            margin-bottom: 38px;
        }

        .login-form-label {
            color: #111d35;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-form-label i {
            color: #1685ff;
            margin-right: 8px;
        }

        .login-input {
            height: 62px;
            border-radius: 14px;
            border: 1px solid #d6e0ed;
            background: #f8fafd;

            padding-left: 18px;

            font-size: 16px;
        }

        .login-input:focus {
            background: white;
            border-color: #1685ff;

            box-shadow:
                0 0 0 4px rgba(22, 133, 255, .10);
        }

        .password-box {
            position: relative;
        }

        .password-box .login-input {
            padding-right: 55px;
        }

        .password-toggle {
            position: absolute;

            right: 18px;
            top: 50%;

            transform: translateY(-50%);

            border: none;
            background: transparent;

            color: #8798b1;
            font-size: 19px;

            cursor: pointer;
        }

        .login-button {
            width: 100%;
            height: 62px;

            margin-top: 15px;

            border: none;
            border-radius: 14px;

            background: #1685f8;
            color: white;

            font-size: 17px;
            font-weight: 700;

            box-shadow:
                0 12px 30px rgba(22, 133, 248, .25);

            transition: .2s;
        }

        .login-button:hover {
            background: #0877e5;
            transform: translateY(-2px);
        }

        .login-alert {
            border: none;
            border-radius: 13px;
            padding: 15px 18px;

            background: #fff0f1;
            color: #d9364e;

            margin-bottom: 25px;
        }

        .login-help {
            text-align: center;
            color: #91a0b5;
            font-size: 13px;
            margin-top: 25px;
        }


        /* ============================= */
        /* RESPONSIVE                    */
        /* ============================= */

        @media(max-width: 900px) {

            .login-left {
                display: none;
            }

            .login-right {
                width: 100%;
            }

        }

        @media(max-width: 576px) {

            .login-right {
                padding: 25px;
            }

            .login-container h2 {
                font-size: 30px;
            }

        }

    </style>

</head>

<body>


<div class="login-page">


    <!-- ========================================= -->
    <!-- PARTIE GAUCHE                             -->
    <!-- ========================================= -->

    <div class="login-left">


        <div class="login-logo">

            <div class="login-logo-icon">
                <i class="fa-solid fa-network-wired"></i>
            </div>

            <div>

                <h2>NetModern</h2>

                <span>Infrastructure</span>

            </div>

        </div>



        <div class="login-presentation">

            <div class="login-small-title">
                Administration réseau
            </div>

            <h1>
                Gérez votre infrastructure simplement.
            </h1>

            <p>
                Une plateforme centralisée pour superviser vos
                serveurs, switchs, interventions et tests réseau.
            </p>


            <div class="login-features">

                <div class="login-feature">
                    <i class="fa-solid fa-shield-halved"></i>
                    Accès sécurisé
                </div>

                <div class="login-feature">
                    <i class="fa-solid fa-server"></i>
                    Infrastructure
                </div>

                <div class="login-feature">
                    <i class="fa-solid fa-chart-line"></i>
                    Supervision
                </div>

            </div>

        </div>


        <div class="login-copyright">
            © <?php echo date('Y'); ?> NetModern — Plateforme de gestion réseau
        </div>


    </div>



    <!-- ========================================= -->
    <!-- PARTIE DROITE                             -->
    <!-- ========================================= -->

    <div class="login-right">


        <div class="login-container">


            <div class="login-security-icon">
                <i class="fa-solid fa-lock"></i>
            </div>


            <h2>Bienvenue</h2>

            <p class="login-subtitle">
                Connectez-vous à votre espace NetModern.
            </p>


            <?php if (!empty($erreur)) { ?>

                <div class="login-alert">

                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                    <?php echo htmlspecialchars($erreur); ?>

                </div>

            <?php } ?>


            <form method="POST">


                <!-- LOGIN -->

                <div class="mb-4">

                    <label class="login-form-label">

                        <i class="fa-solid fa-user"></i>

                        Login

                    </label>

                    <input
                        type="text"
                        name="login"
                        class="form-control login-input"
                        placeholder="Entrez votre login"
                        value="<?php
                        echo isset($_POST['login'])
                            ? htmlspecialchars($_POST['login'])
                            : '';
                        ?>"
                        autocomplete="username"
                        required>

                </div>



                <!-- MOT DE PASSE -->

                <div class="mb-4">

                    <label class="login-form-label">

                        <i class="fa-solid fa-lock"></i>

                        Mot de passe

                    </label>


                    <div class="password-box">

                        <input
                            type="password"
                            name="motDePasse"
                            id="motDePasse"
                            class="form-control login-input"
                            placeholder="Entrez votre mot de passe"
                            autocomplete="current-password"
                            required>


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="afficherMotDePasse()">

                            <i
                                id="eyeIcon"
                                class="fa-solid fa-eye">
                            </i>

                        </button>

                    </div>

                </div>



                <!-- BOUTON -->

                <button
                    type="submit"
                    name="connecter"
                    class="login-button">

                    <i class="fa-solid fa-right-to-bracket me-2"></i>

                    Se connecter

                </button>


            </form>


            <div class="login-help">

                <i class="fa-solid fa-shield-halved me-1"></i>

                Accès réservé aux utilisateurs autorisés de NetModern.

            </div>


        </div>


    </div>


</div>


<script>

function afficherMotDePasse() {

    const champ = document.getElementById("motDePasse");
    const icone = document.getElementById("eyeIcon");

    if (champ.type === "password") {

        champ.type = "text";

        icone.classList.remove("fa-eye");
        icone.classList.add("fa-eye-slash");

    } else {

        champ.type = "password";

        icone.classList.remove("fa-eye-slash");
        icone.classList.add("fa-eye");

    }
}

</script>


</body>
</html>