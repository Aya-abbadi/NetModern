<?php
include("../config/protection.php");
include("../includes/header.php");
include("../config/connexion.php");

/* =========================
   RECHERCHE UTILISATEURS
========================= */

$mot = isset($_GET['recherche']) ? trim($_GET['recherche']) : '';

if ($mot !== '') {

    $motSql = mysqli_real_escape_string($connexion, $mot);

    $result = mysqli_query(
        $connexion,
        "SELECT * FROM utilisateur
         WHERE nom LIKE '%$motSql%'
         OR prenom LIKE '%$motSql%'
         OR login LIKE '%$motSql%'
         OR email LIKE '%$motSql%'
         OR role LIKE '%$motSql%'
         ORDER BY idUtilisateur DESC"
    );

} else {

    $result = mysqli_query(
        $connexion,
        "SELECT * FROM utilisateur
         ORDER BY idUtilisateur DESC"
    );
}

/* Nombre total d'utilisateurs */
$totalResult = mysqli_query(
    $connexion,
    "SELECT COUNT(*) AS total FROM utilisateur"
);

$totalUtilisateur = mysqli_fetch_assoc($totalResult)['total'];
?>

<div class="container-fluid">

    <?php include("../includes/menu.php"); ?>

    <main class="nm-main">

        <!-- =========================
             EN-TÊTE DE PAGE
        ========================== -->

        <section class="nm-users-page">

            <div class="nm-users-header">

                <div>
                    <span class="nm-section-label">
                        GESTION DES COMPTES
                    </span>

                    <h1>Utilisateurs</h1>

                    <p>
                        Gérez les comptes et les accès à la plateforme NetModern.
                    </p>
                </div>

                <a href="ajouter.php" class="nm-user-add-btn">
                    <i class="fa-solid fa-user-plus"></i>
                    Ajouter un utilisateur
                </a>

            </div>


            <!-- =========================
                 PETITE STATISTIQUE
            ========================== -->

            <div class="nm-user-stat">

                <div class="nm-user-stat-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>
                    <span>Utilisateurs enregistrés</span>
                    <strong><?= $totalUtilisateur; ?></strong>
                </div>

            </div>


            <!-- =========================
                 TABLEAU
            ========================== -->

            <div class="nm-users-panel">

                <div class="nm-users-panel-header">

                    <div>
                        <span class="nm-section-label">
                            RÉPERTOIRE
                        </span>

                        <h2>Liste des utilisateurs</h2>
                    </div>


                    <!-- RECHERCHE -->

                    <form method="GET" class="nm-user-search">

                        <div class="nm-user-search-input">

                            <i class="fa-solid fa-magnifying-glass"></i>

                            <input
                                type="text"
                                name="recherche"
                                placeholder="Nom, prénom, email, login..."
                                value="<?= htmlspecialchars($mot); ?>"
                            >

                        </div>

                        <button type="submit">
                            Rechercher
                        </button>

                        <?php if ($mot !== '') { ?>

                            <a href="liste.php" class="nm-search-reset">
                                <i class="fa-solid fa-xmark"></i>
                            </a>

                        <?php } ?>

                    </form>

                </div>


                <!-- TABLE -->

                <div class="nm-users-table-wrapper">

                    <table class="nm-users-table">

                        <thead>

                            <tr>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th>Rôle</th>
                                <th class="nm-table-center">Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                        <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                                <tr>

                                    <!-- UTILISATEUR -->

                                    <td>

                                        <div class="nm-user-profile">

                                            <div class="nm-user-avatar">

                                                <?= strtoupper(
                                                    substr($row['prenom'], 0, 1) .
                                                    substr($row['nom'], 0, 1)
                                                ); ?>

                                            </div>

                                            <div>

                                                <strong>
                                                    <?= htmlspecialchars(
                                                        $row['prenom'] . " " . $row['nom']
                                                    ); ?>
                                                </strong>

                                                <span>
                                                    ID #<?= $row['idUtilisateur']; ?>
                                                </span>

                                            </div>

                                        </div>

                                    </td>


                                    <!-- EMAIL -->

                                    <td>

                                        <div class="nm-user-email">

                                            <i class="fa-regular fa-envelope"></i>

                                            <?= htmlspecialchars($row['email']); ?>

                                        </div>

                                    </td>


                                    <!-- LOGIN -->

                                    <td>

                                        <span class="nm-login-badge">

                                            <i class="fa-regular fa-user"></i>

                                            <?= htmlspecialchars($row['login']); ?>

                                        </span>

                                    </td>


                                    <!-- ROLE -->

                                    <td>

                                        <?php
                                        $roleClass = "nm-role-default";

                                        if ($row['role'] == "Administrateur") {
                                            $roleClass = "nm-role-admin";
                                        }
                                        elseif ($row['role'] == "Technicien") {
                                            $roleClass = "nm-role-tech";
                                        }
                                        elseif ($row['role'] == "Responsable DSI") {
                                            $roleClass = "nm-role-dsi";
                                        }
                                        ?>

                                        <span class="nm-role <?= $roleClass; ?>">

                                            <i class="fa-solid fa-circle"></i>

                                            <?= htmlspecialchars($row['role']); ?>

                                        </span>

                                    </td>


                                    <!-- ACTIONS -->

                                    <td>

                                        <div class="nm-user-actions">

                                            <a
                                                href="modifier.php?id=<?= $row['idUtilisateur']; ?>"
                                                class="nm-action-edit"
                                                title="Modifier"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                                Modifier
                                            </a>


                                            <a
                                                href="supprimer.php?id=<?= $row['idUtilisateur']; ?>"
                                                class="nm-action-delete"
                                                title="Supprimer"
                                                onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>

                                <td colspan="5">

                                    <div class="nm-users-empty">

                                        <i class="fa-solid fa-users-slash"></i>

                                        <h3>Aucun utilisateur trouvé</h3>

                                        <p>
                                            Aucun compte ne correspond à votre recherche.
                                        </p>

                                        <a href="liste.php">
                                            Afficher tous les utilisateurs
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

<?php include("../includes/footer.php"); ?>