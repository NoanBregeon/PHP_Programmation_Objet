<?php include __DIR__ . '/../../layouts/header.php'; ?>

<h2>🚗 Véhicules disponibles</h2>
<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="vehicule">
    <input type="hidden" name="action" value="flotte">

    <label for="sort">Trier par :</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="">-- Choisir --</option>
        <option value="marque">Marque A → Z</option>
        <option value="prix_asc">Prix croissant</option>
        <option value="prix_desc">Prix décroissant</option>
        <option value="places">Nombre de places</option>
    </select>
</form>


<?php if (!empty($vehicules)): ?>
    <?php foreach ($vehicules as $vehicule): ?>
        <div class="vehicle-card">
            <h3><?= htmlspecialchars($vehicule['nom'] ?? 'Nom inconnu') ?>&nbsp&nbsp<?= htmlspecialchars($vehicule['marque'] ?? 'Inconnue') ?></h3>
            
            <p><strong>Prix :</strong> 
                <?= isset($vehicule['prix_journalier']) ? htmlspecialchars($vehicule['prix_journalier']) . ' € / jour' : 'Non renseigné' ?>
            </p>
            
            <p><strong>Boîte automatique :</strong> 
                <?= isset($vehicule['boite_auto']) && $vehicule['boite_auto'] ? 'Oui' : 'Non' ?>
            </p>
            
            <p><strong>Nombre de places :</strong> 
                <?= htmlspecialchars($vehicule['nb_places'] ?? 'Inconnu') ?>
            </p>


            <?php if (!empty($vehicule['image'])): ?>
                <?php $image = $vehicule['image'] ?? '';
                $image = str_replace(['../', './'], '', $image); // Nettoyage du chemin
                ?>
                
<?php if (!empty($image)): ?>
    <img src="/php/PHP_Programmation_Objet/Page_Internet/<?= htmlspecialchars($image) ?>"
         alt="<?= htmlspecialchars($vehicule['nom'] ?? 'Véhicule') ?>" width="300">
<?php else: ?>
    <p><em>Aucune image disponible</em></p>
<?php endif; ?>

            <?php else: ?>
                <p><em>Aucune image disponible</em></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
    <p>
        <a href="index.php?controller=vehicule&action=modifier&id=<?= $vehicule['id'] ?>" class="btn-modifier">✏️ Modifier</a>
        <a href="index.php?controller=vehicule&action=delete&id=<?= $vehicule['id'] ?>" class="btn-supprimer">🗑️ Supprimer</a>

    </p>
<?php endif; ?>

        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun véhicule disponible pour le moment.</p>
<?php endif; ?>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>

