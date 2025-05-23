<?php
function render_content() {
    ?>
    <form action="ajouter_materiel_handler.php" method="POST">
      <fieldset>
        <legend>Nouveau Matériel</legend>

        <div class="form-group">
          <label for="numero_ordre">Numéro d'ordre:</label>
          <input type="text" id="numero_ordre" name="numero_ordre" required>
        </div>

        <div class="form-group">
          <label>Département :</label>
          <div class="radio-group">
            <input type="radio" id="gei" name="departement" value="GEI" checked>
            <label for="gei">GEI</label>
            <input type="radio" id="gi" name="departement" value="GI">
            <label for="gi">GI</label>
          </div>
        </div>

        <div class="form-group">
          <label for="categorie">Catégorie:</label>
          <input type="text" id="categorie" name="categorie" required>
        </div>

        <div class="form-group">
          <label for="designation">Désignation:</label>
          <input type="text" id="designation" name="designation" required>
        </div>

        <div class="form-group">
          <label for="fournisseur">Fournisseur:</label>
          <input type="text" id="fournisseur" name="fournisseur">
        </div>

        <div class="form-group">
          <label for="prix_ht">Prix HT:</label>
          <input type="text" id="prix_ht" name="prix_ht">
        </div>

        <div class="form-group">
          <label for="date_achat">Date d'acquisition:</label>
          <input type="date" id="date_achat" name="date_achat">
        </div>

        <div class="button-group">
          <button type="submit" class="btn primary">Ajouter</button>
          <button type="reset" class="btn secondary">Annuler</button>
        </div>
      </fieldset>
    </form>
    <?php
}
include 'layout.php';
