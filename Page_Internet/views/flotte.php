<?php include 'layouts/header.php'; ?>

<main>
    <h2>🚗 Véhicules disponibles</h2>

    <?php if (!empty($vehicules)): ?>
        <div class="vehicule-liste">
            <?php foreach ($vehicules as $v): ?>
                <div class="vehicule-card">
                    <h3><?= htmlspecialchars($v['marque']) ?> <?= htmlspecialchars($v['modele']) ?></h3>
                    <p><strong>Année :</strong> <?= $v['annee'] ?></p>
                    <p><strong>Prix :</strong> <?= $v['prix'] ?> € / jour</p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun véhicule disponible pour le moment.</p>
    <?php endif; ?>
</main>

<?php include 'layouts/footer.php'; ?>
