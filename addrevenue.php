<?php require_once 'function.php'; 

$id = getid();
$pdo = connection(); 
$error = false;
$categorie = categorie($pdo);
$detailsmembers = detailsmembers($pdo, $id);
// Le formulaire a été soumis
if (!empty($_POST)) {

    // vérifie que le nom est bien renseigné
    if (empty($_POST['inc_cat_id'])) {
        $errors['inc_cat_id'] = 'Le champ est requis';
    }else if(!filter_var($_POST['inc_cat_id'], FILTER_VALIDATE_INT)){
        $errors['inc_cat_id'] = 'La valeur renseignée est incorrecte !';
    }
    if (empty($_POST['inc_amount'])) {
        $errors['inc_amount'] = 'Le champ est requis';
    }else if(!preg_match($regexnumber, $_POST['inc_amount'])){
        $errors['inc_amount'] = 'La valeur renseignée est incorrecte !';
    }

    
    if (empty($_POST['inc_date'])) {
        $errors['inc_date'] = 'Le champ est requis';
    }else if(!preg_match($regexDate, $_POST['inc_date'])){
        $errors['inc_date'] = 'La valeur renseignée est incorrecte !';
    }

    if (empty($errors)) {
        $inc_cat_id = htmlentities($_POST['inc_cat_id']);
        $inc_date = htmlentities($_POST['inc_date']);
        $inc_amount = (int) htmlentities($_POST['inc_amount']);
        if (addrevenue($pdo, $inc_amount, $inc_date, $inc_cat_id, $id)) {
            $success = true;
        }
    }
}
?>
<?php require_once 'inc/header.php' ?>

<div class="container">
        <?php if (isset($success)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p>Revenue créé avec succès !</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-md-5 p-3 text-light">
            <h2>Declarer un revenu</h2>
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="mb-3" for="inc_cat_id">Rentrée:</label>
                        <select class="form-select" name="inc_cat_id" id="inc_cat_id">
                            <option value="" disabled selected>Choisir La raison de votre rentrée</option>
                            <?php foreach($categorie as $dm) : ?>
                            <option value="<?= $dm['inc_cat_id'] ?>"><?= $dm['inc_cat_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="mb-0 text-danger"><?= $errors['inc_cat_id'] ?? '' ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="mb-3" for="inc_amount">Montant :</label>
                        <input name="inc_amount" class="form-control" placeholder="Montant de la rentrée" id="inc_amount" type="text">
                        <p class="mb-0 text-danger"><?= $errors['inc_amount'] ?? '' ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="mb-3" for="inc_date">Date :</label>
                        <input name="inc_date" class="form-control" id="inc_date" type="date">
                        <p class="mb-0 text-danger"><?= $errors['inc_date'] ?? '' ?></p>
                    </div>
                    <input class="btn btn-dark" type="submit" value="Enregister">
                </form>
            </div>
            <div class="col-md-5">
                <img src="assets/img/undraw_Payments_re_77x0.svg" alt="">
            </div>
        </div>
    </div>

<?php require_once 'inc/footer.php' ?>