<?php
session_start();
include("includes/header.php");

include("config/protection.php");
include("config/connexion.php");

function compter($connexion,$table)
{
    $result = mysqli_query($connexion,"SELECT COUNT(*) AS total FROM $table");
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}


if(!isset($_SESSION['utilisateur'])){
    header("Location: utilisateurs/login.php");
    exit();
}

include("config/connexion.php");



$nbUtilisateurs=compter($connexion,"utilisateur");
$nbServeurs=compter($connexion,"serveur");
$nbSwitchs=compter($connexion,"switchs");
$nbInterventions=compter($connexion,"intervention");
$nbRapports=compter($connexion,"rapport");
$nbTests=compter($connexion,"test_reseau");
// Récupérer les 5 interventions les plus récentes
$sqlRecentes = "SELECT *
                FROM intervention
                ORDER BY dateIntervention DESC, idIntervention DESC
                LIMIT 5";

$resultRecentes = mysqli_query($connexion, $sqlRecentes);


?>

<?php include("includes/menu.php"); ?>

<main class="nm-main">

    <!-- HERO NETMODERN -->
<section class="nm-hero">

    <div class="nm-hero-overlay"></div>

    <div class="nm-hero-content">

        <span class="nm-hero-badge">
            <i class="fa-solid fa-circle-nodes"></i>
            Infrastructure & Réseau
        </span>

        <h1>
            Supervisez votre infrastructure
            <span>avec NetModern</span>
        </h1>

        <p>
            Une plateforme moderne pour gérer vos serveurs,
            équipements réseau, interventions et rapports
            depuis un seul espace.
        </p>

        <div class="nm-hero-actions">

            <a href="serveurs/liste.php" class="nm-btn-primary">
                <i class="fa-solid fa-server"></i>
                Voir les serveurs
            </a>

            <a href="interventions/liste.php" class="nm-btn-secondary">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                Interventions
            </a>

        </div>

        <div class="nm-hero-status">

            <div>
                <i class="fa-solid fa-shield-halved"></i>
                <span>
                    <strong>Sécurisé</strong>
                    Gestion centralisée
                </span>
            </div>

            <div>
                <i class="fa-solid fa-chart-line"></i>
                <span>
                    <strong>Supervision</strong>
                    Suivi de l'infrastructure
                </span>
            </div>

            <div>
                <i class="fa-solid fa-bolt"></i>
                <span>
                    <strong>Rapide</strong>
                    Accès aux opérations
                </span>
            </div>

        </div>

    </div>

</section>





    <!-- ================================
     DASHBOARD SUPERVISION
================================ -->

<section class="nm-dashboard-section">

    <div class="nm-section-header">
        <div>
            <span class="nm-section-label">VUE D'ENSEMBLE</span>
            <h2>État de l'infrastructure</h2>
            <p>Supervision générale de votre environnement NetModern</p>
        </div>

        <div class="nm-live-status">
            <span></span>
            Système opérationnel
        </div>
    </div>


    <!-- STATISTIQUES -->
    <div class="nm-stats-grid">

        <!-- SERVEURS -->
        <a href="serveurs/liste.php" class="nm-stat-card">
            <div class="nm-stat-icon">
                <i class="fa-solid fa-server"></i>
            </div>

            <div class="nm-stat-info">
                <span>Serveurs</span>
                <strong><?= $nbServeurs; ?></strong>
                <small>Équipements enregistrés</small>
            </div>

            <i class="fa-solid fa-arrow-right nm-stat-arrow"></i>
        </a>


        <!-- SWITCHS -->
        <a href="switchs/liste.php" class="nm-stat-card">
            <div class="nm-stat-icon">
                <i class="fa-solid fa-network-wired"></i>
            </div>

            <div class="nm-stat-info">
                <span>Switchs</span>
                <strong><?= $nbSwitchs; ?></strong>
                <small>Équipements réseau</small>
            </div>

            <i class="fa-solid fa-arrow-right nm-stat-arrow"></i>
        </a>


        <!-- INTERVENTIONS -->
        <a href="interventions/liste.php" class="nm-stat-card">
            <div class="nm-stat-icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>

            <div class="nm-stat-info">
                <span>Interventions</span>
                <strong><?= $nbInterventions; ?></strong>
                <small>Interventions enregistrées</small>
            </div>

            <i class="fa-solid fa-arrow-right nm-stat-arrow"></i>
        </a>


        <!-- TESTS -->
        <a href="tests/liste.php" class="nm-stat-card">
            <div class="nm-stat-icon">
                <i class="fa-solid fa-wave-square"></i>
            </div>

            <div class="nm-stat-info">
                <span>Tests réseau</span>
                <strong><?= $nbTests; ?></strong>
                <small>Tests de connectivité</small>
            </div>

            <i class="fa-solid fa-arrow-right nm-stat-arrow"></i>
        </a>

    </div>


    <!-- PARTIE INFÉRIEURE -->
    <div class="nm-dashboard-grid">

        <!-- INFRASTRUCTURE -->
        <div class="nm-panel">

            <div class="nm-panel-title">
                <div>
                    <span>INFRASTRUCTURE</span>
                    <h3>Accès rapide</h3>
                </div>

                <i class="fa-solid fa-layer-group"></i>
            </div>

            <div class="nm-quick-links">

                <a href="utilisateurs/liste.php">
                    <i class="fa-solid fa-users"></i>
                    <div>
                        <strong>Utilisateurs</strong>
                        <span><?= $nbUtilisateurs; ?> comptes</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="serveurs/liste.php">
                    <i class="fa-solid fa-server"></i>
                    <div>
                        <strong>Serveurs</strong>
                        <span>Administrer les équipements</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="switchs/liste.php">
                    <i class="fa-solid fa-network-wired"></i>
                    <div>
                        <strong>Réseau</strong>
                        <span>Gérer les switchs</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

            </div>

        </div>


        <!-- MAINTENANCE -->
        <div class="nm-panel">

            <div class="nm-panel-title">
                <div>
                    <span>MAINTENANCE</span>
                    <h3>Suivi des opérations</h3>
                </div>

                <i class="fa-solid fa-chart-line"></i>
            </div>

            <div class="nm-operation">

                <div class="nm-operation-icon">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>

                <div>
                    <span>Interventions</span>
                    <strong><?= $nbInterventions; ?></strong>
                </div>

                <a href="interventions/liste.php">
                    Consulter
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

            <div class="nm-operation">

                <div class="nm-operation-icon">
                    <i class="fa-solid fa-file-lines"></i>
                </div>

                <div>
                    <span>Rapports</span>
                    <strong><?= $nbRapports; ?></strong>
                </div>

                <a href="rapports/liste.php">
                    Consulter
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

        </div>


</section>
<!-- ================================
     ACTIVITÉ RÉCENTE
================================ -->

<section class="nm-recent-section">

    <div class="nm-recent-header">
        <div>
            <span class="nm-section-label">SUPERVISION</span>
            <h2>Activité récente</h2>
            <p>Dernières interventions enregistrées sur NetModern</p>
        </div>

        <a href="interventions/liste.php" class="nm-recent-all">
            Voir toutes
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="nm-recent-list">

        <?php if ($resultRecentes && mysqli_num_rows($resultRecentes) > 0): ?>

            <?php while ($intervention = mysqli_fetch_assoc($resultRecentes)): ?>

                <div class="nm-recent-item">

                    <div class="nm-recent-icon">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>

                    <div class="nm-recent-content">

                        <div class="nm-recent-top">
                            <strong>
                                <?= htmlspecialchars($intervention['type'] ?? 'Intervention'); ?>
                            </strong>

                            <span class="nm-recent-date">
                                <i class="fa-regular fa-calendar"></i>
                                <?= htmlspecialchars($intervention['dateIntervention']); ?>
                            </span>
                        </div>

                        <p>
                            <?= htmlspecialchars($intervention['description'] ?? 'Aucune description'); ?>
                        </p>

                        <span class="nm-recent-result">
                            <?= htmlspecialchars($intervention['resultat'] ?? 'Non renseigné'); ?>
                        </span>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="nm-recent-empty">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <h3>Aucune activité récente</h3>
                <p>Les dernières interventions apparaîtront ici.</p>
            </div>

        <?php endif; ?>

    </div>

</section>
</main>

<?php include("includes/footer.php"); ?>