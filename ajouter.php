<?php
include("../config/protection.php");
include("../includes/header.php");
include("../config/connexion.php");

if (isset($_POST['ajouter'])) {

    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $email = mysqli_real_escape_string($connexion, $_POST['email']);
    $login = mysqli_real_escape_string($connexion, $_POST['login']);
$motDePasse = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($connexion, $_POST['role']);

    $sql = "INSERT INTO utilisateur
            (nom, prenom, email, login, motDePasse, role)
            VALUES
            ('$nom', '$prenom', '$email', '$login', '$motDePasse', '$role')";

    if (mysqli_query($connexion, $sql)) {
        header("Location: liste.php");
        exit;
    }

    $erreur = "Impossible d'ajouter l'utilisateur.";
}
?>

<div class="container-fluid">

    <?php include("../includes/menu.php"); ?>

    <main class="nm-main">

        <section class="nm-user-form-page">

            <!-- EN-TÊTE -->

            <div class="nm-form-page-header">

                <div>
                    <a href="liste.php" class="nm-form-back">
                        <i class="fa-solid fa-arrow-left"></i>
                        Utilisateurs
                    </a>

                    <span class="nm-section-label">
                        GESTION DES COMPTES
                    </span>

                    <h1>Nouvel utilisateur</h1>

                    <p>
                        Créez un nouveau compte et définissez ses accès
                        à la plateforme NetModern.
                    </p>
                </div>

                <div class="nm-form-header-icon">
                    <i class="fa-solid fa-user-plus"></i>
                </div>

            </div>


            <!-- FORMULAIRE -->

            <div class="nm-user-form-card">

                <div class="nm-form-card-header">

                    <div class="nm-form-card-icon">
                        <i class="fa-solid fa-address-card"></i>
                    </div>

                    <div>
                        <h2>Informations du compte</h2>
                        <p>
                            Renseignez les informations du nouvel utilisateur.
                        </p>
                    </div>

                </div>


                <?php if (isset($erreur)) { ?>

                    <div class="nm-form-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <?= htmlspecialchars($erreur); ?>
                    </div>

                <?php } ?>


                <form method="POST" class="nm-modern-form">

                    <div class="nm-form-grid">

                        <!-- NOM -->

                        <div class="nm-form-group">

                            <label>
                                <i class="fa-regular fa-user"></i>
                                Nom
                            </label>

                            <input
                                type="text"
                                name="nom"
                                placeholder="Ex : Benali"
                                required
                            >

                        </div>


                        <!-- PRENOM -->

                        <div class="nm-form-group">

                            <label>
                                <i class="fa-regular fa-user"></i>
                                Prénom
                            </label>

                            <input
                                type="text"
                                name="prenom"
                                placeholder="Ex : Ali"
                                required
                            >

                        </div>


                        <!-- EMAIL -->

                        <div class="nm-form-group">

                            <label>
                                <i class="fa-regular fa-envelope"></i>
                                Adresse email
                            </label>

                            <input
                                type="email"
                                name="email"
                                placeholder="nom@netmodern.com"
                                required
                            >

                        </div>


                        <!-- LOGIN -->

                        <div class="nm-form-group">

                            <label>
                                <i class="fa-solid fa-at"></i>
                                Login
                            </label>

                            <input
                                type="text"
                                name="login"
                                placeholder="Ex : ali"
                                required
                            >

                        </div>


                        <!-- MOT DE PASSE -->

                        <div class="nm-form-group">

                            <label>
                                <i class="fa-solid fa-lock"></i>
                                Mot de passe
                            </label>

                            <div class="nm-password-field">

                                <input
                                    type="password"
                                    name="motDePasse"
                                    id="motDePasse"
                                    placeholder="Entrez un mot de passe"
                                    required
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    title="Afficher le mot de passe"
                                >
                                    <i
                                        class="fa-regular fa-eye"
                                        id="passwordIcon"
                                    ></i>
                                </button>

                            </div>

                        </div>


                        <!-- ROLE -->

                        <div class="nm-form-group">

                            <label>
                                <i class="fa-solid fa-user-shield"></i>
                                Rôle
                            </label>

                            <select name="role" required>

                                <option value="">
                                    Sélectionner un rôle
                                </option>

                                <option value="Administrateur">
                                    Administrateur
                                </option>

                                <option value="Technicien">
                                    Technicien
                                </option>

                                <option value="Responsable DSI">
                                    Responsable DSI
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- INFO -->

                    <div class="nm-form-info">

                        <i class="fa-solid fa-shield-halved"></i>

                        <div>
                            <strong>Accès à NetModern</strong>
                            <span>
                                Le rôle sélectionné déterminera les droits
                                et fonctionnalités accessibles à cet utilisateur.
                            </span>
                        </div>

                    </div>


                    <!-- BOUTONS -->

                    <div class="nm-form-actions">

                        <a href="liste.php" class="nm-form-cancel">
                            <i class="fa-solid fa-arrow-left"></i>
                            Annuler
                        </a>

                        <button
                            type="submit"
                            name="ajouter"
                            class="nm-form-submit"
                        >
                            <i class="fa-solid fa-floppy-disk"></i>
                            Créer l'utilisateur
                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>


<script>
function togglePassword() {

    const input = document.getElementById("motDePasse");
    const icon = document.getElementById("passwordIcon");

    if (input.type === "password") {

        input.type = "text";

        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    } else {

        input.type = "password";

        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

<?php include("../includes/footer.php"); ?>