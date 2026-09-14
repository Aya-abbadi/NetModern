<?php
include("../config/protection.php");
include("../config/connexion.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM utilisateur WHERE idUtilisateur = $id";
$resultat = mysqli_query($connexion, $sql);
$u = mysqli_fetch_assoc($resultat);

if (!$u) {
    header("Location: liste.php");
    exit;
}

if (isset($_POST['modifier'])) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $motDePasse = $_POST['motDePasse'];
    $role = $_POST['role'];

    $sql = "UPDATE utilisateur SET
            nom='$nom',
            prenom='$prenom',
            email='$email',
            login='$login',
            motDePasse='$motDePasse',
            role='$role'
            WHERE idUtilisateur=$id";

    mysqli_query($connexion, $sql);

    header("Location: liste.php");
    exit;
}

include("../includes/header.php");
include("../includes/menu.php");
?>

<main class="nm-main">

    <section class="nm-user-form-page">

        <!-- Retour -->
        <a href="liste.php" class="nm-form-back">
            <i class="fa-solid fa-arrow-left"></i>
            Utilisateurs
        </a>

        <!-- En-tête -->
        <div class="nm-form-page-header">

            <div>
                <span class="nm-section-label">
                    GESTION DES COMPTES
                </span>

                <h1>Modifier l'utilisateur</h1>

                <p>
                    Mettez à jour les informations et les accès
                    de cet utilisateur.
                </p>
            </div>

            <div class="nm-form-page-icon">
                <i class="fa-solid fa-user-pen"></i>
            </div>

        </div>


        <!-- CARTE -->
        <div class="nm-user-form-card">

            <!-- Titre carte -->
            <div class="nm-user-form-card-header">

                <div class="nm-user-form-card-icon">
                    <i class="fa-solid fa-address-card"></i>
                </div>

                <div>
                    <h2>Informations du compte</h2>

                    <p>
                        Modifiez les informations de l'utilisateur
                        sélectionné.
                    </p>
                </div>

            </div>


            <form method="POST">

                <div class="nm-user-form-grid">

                    <!-- NOM -->
                    <div class="nm-user-field">

                        <label>
                            <i class="fa-regular fa-user"></i>
                            Nom
                        </label>

                        <input
                            type="text"
                            name="nom"
                            value="<?php echo htmlspecialchars($u['nom']); ?>"
                            required
                        >

                    </div>


                    <!-- PRENOM -->
                    <div class="nm-user-field">

                        <label>
                            <i class="fa-regular fa-user"></i>
                            Prénom
                        </label>

                        <input
                            type="text"
                            name="prenom"
                            value="<?php echo htmlspecialchars($u['prenom']); ?>"
                            required
                        >

                    </div>


                    <!-- EMAIL -->
                    <div class="nm-user-field">

                        <label>
                            <i class="fa-regular fa-envelope"></i>
                            Adresse email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="<?php echo htmlspecialchars($u['email']); ?>"
                            required
                        >

                    </div>


                    <!-- LOGIN -->
                    <div class="nm-user-field">

                        <label>
                            <i class="fa-solid fa-at"></i>
                            Login
                        </label>

                        <input
                            type="text"
                            name="login"
                            value="<?php echo htmlspecialchars($u['login']); ?>"
                            required
                        >

                    </div>


                    <!-- MOT DE PASSE -->
                    <div class="nm-user-field">

                        <label>
                            <i class="fa-solid fa-lock"></i>
                            Mot de passe
                        </label>

                        <div class="nm-password-field">

                            <input
                                type="password"
                                id="motDePasse"
                                name="motDePasse"
                                value="<?php echo htmlspecialchars($u['motDePasse']); ?>"
                                required
                            >

                            <button
                                type="button"
                                class="nm-password-toggle"
                                onclick="togglePassword()"
                            >
                                <i
                                    id="passwordIcon"
                                    class="fa-regular fa-eye"
                                ></i>
                            </button>

                        </div>

                    </div>


                    <!-- ROLE -->
                    <div class="nm-user-field">

                        <label>
                            <i class="fa-solid fa-user-shield"></i>
                            Rôle
                        </label>

                        <select name="role" required>

                            <option
                                value="Administrateur"
                                <?php if ($u['role'] == 'Administrateur') echo 'selected'; ?>
                            >
                                Administrateur
                            </option>

                            <option
                                value="Technicien"
                                <?php if ($u['role'] == 'Technicien') echo 'selected'; ?>
                            >
                                Technicien
                            </option>

                            <option
                                value="Responsable DSI"
                                <?php if ($u['role'] == 'Responsable DSI') echo 'selected'; ?>
                            >
                                Responsable DSI
                            </option>

                        </select>

                    </div>

                </div>


                <!-- INFORMATION -->
                <div class="nm-user-access-info">

                    <i class="fa-solid fa-shield-halved"></i>

                    <div>
                        <strong>Gestion des accès</strong>

                        <p>
                            Le rôle sélectionné détermine les droits
                            et fonctionnalités accessibles à cet utilisateur.
                        </p>
                    </div>

                </div>


                <!-- BOUTONS -->
                <div class="nm-user-form-actions">

                    <a href="liste.php" class="nm-btn-cancel">
                        <i class="fa-solid fa-arrow-left"></i>
                        Annuler
                    </a>

                    <button
                        type="submit"
                        name="modifier"
                        class="nm-btn-save"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>

    </section>

</main>


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