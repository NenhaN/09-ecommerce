<?php 
require_once('inc/init.inc.php');

if(isset($_GET['cat']) && ! empty($_GET['cat']))
{
    $prodPdoS = $bdd->prepare("SELECT * FROM produit WHERE categorie = :categorie");
    $prodPdoS->bindValue(':categorie', $_GET['cat'], PDO::PARAM_STR);
   $prodPdoS->execute();


if($prodPdoS->rowCount() > 0)
{
    $products = $prodPdoS->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>'; print_r($products);  echo '</pre>';
}
else
{
    header('location: boutique.php');
}

} 

else
{
    $prodPdoS = $bdd->query ("SELECT * FROM produit");
    $products = $prodPdoS->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>'; print_r($products);  echo '</pre>';
}



require_once('inc/inc_front/header.inc.php');
require_once('inc/inc_front/nav.inc.php');
?>

    <h1 class="text-center my-5">Shopping</h1>

    <p class="my-5">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Delectus, labore. Dolor voluptatem nobis ea deleniti, sit possimus eligendi iure recusandae rem eius. Doloribus delectus quas, tempore rem laboriosam nesciunt pariatur velit, illum sint, necessitatibus ea eaque provident. Cupiditate alias repellat aliquid veniam quibusdam corrupti, non odit asperiores illo eligendi necessitatibus! Fugiat quo in provident minus ullam praesentium natus amet sequi delectus quia incidunt beatae rem, labore quisquam pariatur accusantium exercitationem enim suscipit consequatur dolorum animi commodi saepe? Eos quas, aliquid blanditiis officia ipsum natus ea. Porro officiis qui totam unde dignissimos nesciunt repudiandae possimus numquam pariatur placeat! Magnam et aperiam hic officiis? Veniam, laborum voluptate nemo, qui tempore voluptates sed at, suscipit facere sint totam eos beatae nam aperiam molestiae! Asperiores non officia cupiditate itaque sapiente fuga earum illo quibusdam? Adipisci quia aliquid laboriosam saepe, dignissimos eos expedita molestiae quaerat nisi quae ratione provident, optio ad. Recusandae iure hic culpa!</p>

    <div class="accordion col-12 col-sm-10 col-md-4 col-lg-3 col-xl-3 mx-auto my-5" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Catégories
                </button>
            </h2>

            <?php
            $catPdoS = $bdd->query("SELECT DISTINCT(categorie) FROM produit");
            ?>

            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php while($arrayCat = $catPdoS->fetch(PDO::FETCH_ASSOC)): 
                            // echo '<pre>'; print_r($arrayCat);  echo '</pre>';
                        ?>
                    <p><a href="?cat=<?= $arrayCat ['categorie'] ?>" class="alert-link text-dark"><?= $arrayCat ['categorie'] ?></a></p>
                    <?php endwhile; ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">

    <?php foreach($products as $key => $tabProducts): ?>

        <div class="col">
            <div class="card shadow-sm rounded">
                <a href="fiche_produit.php?id_produit=<?= $tabProducts['id_produit'] ?>"><img src="<?= $tabProducts['photo'] ?>" class="card-img-top" alt="..."></a>
                <div class="card-body">
                    
                    <h5 class="card-title text-center"><a href="fiche_produit.php?id_produit=<?=$tabProducts['id_produit'] ?>" class="alert-link text-dark titre-produit-boutique"><?= $tabProducts['titre'] ?></a></h5>

                    <p class="card-text">
                    <?php 

                   if (iconv_strlen($tabProducts['description']) > 200)
                   {
                       echo substr($tabProducts['description'], 0, 200) . '[...]';
                   }
                   else
                   {
                       echo $tabProducts['description'];
                   }
                
                ?>
                
                </p>

                    <p class="card-text fw-bold"><?= $tabProducts['prix'] ?>€</p>

                    <p class="card-text text-center"><a href="fiche_produit.php?id_produit=<?=$tabProducts['id_produit'] ?>" class="btn btn-outline-dark">En savoir plus</a></p>
                </div>
            </div>
        </div>
     <?php   endforeach; ?>

    </div>

<?php 
require_once('inc/inc_front/footer.inc.php');    