<?php 
require_once('inc/init.inc.php');

//  echo '<pre>'; print_r($_GET); echo '</pre>';

if(connect())
{
    header('location: profil.php');
}



 if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
 {
     unset($_SESSION['user']);
 }

 if (isset($_POST['pseudo_email'], $_POST['password'], $_POST['submit'],) )
{       
    // On selectionne tous dans la table SQL à condition que le pseudo ou l'email saisi dans le formulaire soit égal à un pseudo ou mail stoché dans la BDD
     $verifUser = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo OR email =:email");
     $verifUser->bindValue(':pseudo', $_POST['pseudo_email'], PDO::PARAM_STR);
     $verifUser->bindValue(':email', $_POST['pseudo_email'], PDO::PARAM_STR);
     $verifUser->execute();

    //  echo "nb résultat : " . $verifUser->rowCount() . '<hr>' ;

    //Si rowCount( retourne un résultat de 1, cela veut dire que le pseudo ou mail saisi dans le formaulire existe dans la BDD)
    if ($verifUser->rowCount() > 0) 
    {
        // echo "pseudo ou email OK ! <hr>";

        $user = $verifUser->fetch(PDO::FETCH_ASSOC);
        // echo '<pre>'; print_r($user); echo '</pre>';

        // Controle du mot de passe
        // password_verify () : fonction prédéfinie permettant de comparer une clé de hachage (le mdp crypté en bdd)  à une chaine de caractere (le mdp saisi dans le formulaire)
        if(password_verify($_POST['password'], $user['password']))
        {
            // echo "mot de pass OK !";
            foreach($user as $key => $value)
            {
                if($key != 'password')
                {
                    $_SESSION['user'][$key] =$value;
                }
            }
            // echo '<pre>'; print_r($_SESSION); echo '</pre>';

            // Apres l'authentification de l'utilisateur  on le redirige vers sa page profil
            header('location: profil.php');
        }
        else
        {
            $error = "<p class='col-3 bg-danger text-white text-center mx-auto p-3 mt-3'>Idendification invalide.</p>";
        }

    } 
    else // Sinon, le pseudo email saisi n'est pas connu en BDD, la requete SELECT ne retourne aucun résultat
    {
       $error = "<p class='col-3 bg-danger text-white text-center mx-auto p-3 mt-3'>Idendification invalide.</p>";
    }
    
}



require_once('inc/inc_front/header.inc.php');
require_once('inc/inc_front/nav.inc.php');
?>
    <?php 
    if(isset($_SESSION['valid_inscription'])); 
    if(isset($error)) echo $error;
    ?>


    <h1 class="text-center my-5">Identifiez-vous</h1>

    <form action="" method="post" class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4 mx-auto">
        <div class="mb-3">
            <label for="pseudo_email" class="form-label">Nom d'utilisateur / Email</label>
            <input type="text" class="form-control" id="pseudo_email" name="pseudo_email" placeholder="Saisir votre Email ou votre nom d'utilisateur">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Saisir votre mot de passe">
        </div>
        <div>
            <p class="text-end mb-0"><a href="" class="alert-link text-dark">Pas encore de compte ? Cliquez ici</a></p>
            <p class="text-end m-0 p-0"><a href="" class="alert-link text-dark">Mot de passe oublié ?</a></p>
        </div>
        <input type="submit" name="submit" value="Continuer" class="btn btn-dark">
    </form>

<?php 
// On supprime dans la session l'indice 'valid_valid_inscription' afin d'éviter que le message ne s'affiche tout le temps sur la page connexion
unset($_SESSION['valid_inscription']);
require_once('inc/inc_front/footer.inc.php');        