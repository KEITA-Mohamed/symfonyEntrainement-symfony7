<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="./public/fontawesome-free-6.5.1-web/css/all.css">
    <title>Document</title>
</head>
<body>
    <div id="wrapper">
        <header>
            <h1>Gareva</h1>
            <nav>
                <ul class="ul">
                    <li><a href="accueil">Acceuil</a></li>
                    <li><a href="article">Article</a></li>
                    <li><a href="client">Client</a></li>
                    <li><a href="user">User</a></li>
                    <li><a href="">LigneCommande</a></li>
                </ul>
                
                <div class="search">
                    

                        <input type="text" autocomplete="off" id="mot" name="mot" onkeydown="touche(event)">
                        <button onclick="chercher()">Rechercher</button>
                        
                        <a><i class="fa fa-user fa-2x"></i>MK</a>
                        <ul class="dropdown-menu w100 bg_blue">
                            <li class="nav-item w100 p-2"><a href="user&action=login" class="nav-link">Se connecter</a></li>
                            <li class="nav-item w100 p-2"><a href="" class="nav-link">S'inscrire</a></li>
                            <li class="nav-item w100 p-2"><a href="" class="nav-link">Deconnexion</a></li>
                        </ul>
                    
                </div>
            </nav>
        </header>
        <main id="main">
            <section>
                <div id="section">
                <?=$content?>
                </div>
            </section>
            <aside>
                <div id="aside">
                    <h2>aside</h2>
                </div>
            </aside>
        </main>
        <footer>
            <div id="footer">
                <h2>footer</h2>
            </div>
        </footer>
    </div>
</body>
</html>