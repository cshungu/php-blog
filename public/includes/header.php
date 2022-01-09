<?php
$currentUser  = $currentUser ?? '';
?>
<header>
    <div class="header-container">
        <a href="/" class="logo">Demo Blog</a>
        <div class="header-mobile">
            <div class="header-mobile-icon">
                <img src="../img/mobile-menu.png" class="img-responsive" alt="Image">
            </div>
            <ul class="header-mobile-list">
                <?php if ($currentUser) : ?>
                    <li class=<?php _uri() === _route('article_form') ? 'active' : '' ?>>
                        <a href="/articleForm.php">Écrire un article</a>
                    </li>
                    <li>
                        <a href="/authLogout.php">Déconnexion</a>
                    </li>
                    <li class="<?php _uri() ===  _route('profile') ? 'active' : '' ?>">
                        <a href="/profile.php">
                            Mon espace
                        </a>
                    </li>

                <?php else : ?>
                    <li class=<?php _uri() === _route('auth_register') ? 'active' : '' ?>>
                        <a href="/authRegister.php">Inscription</a>
                    </li>
                    <li class=<?php _uri() ===  _route('auth_login') ? 'active' : '' ?>>
                        <a href="/authLogin.php">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <ul class="header-menu">
            <?php if ($currentUser) : ?>
                <li class=<?php _uri() === _route('article_form') ? 'active' : '' ?>>
                    <a href="/articleForm.php">Écrire un article</a>
                </li>
                <li>
                    <a href="/authLogout.php">Déconnexion</a>
                </li>
                <li class="<?php _uri() === _route('profile') ? 'active' : '' ?> header-profil">
                    <a href="/profile.php">
                        <?php echo $currentUser['firstname'][0] .  $currentUser['lastname'][0] ?>
                    </a>
                </li>

            <?php else : ?>
                <li class=<?php _uri() === _route('auth_register') ? 'active' : '' ?>>
                    <a href="/authRegister.php">Inscription</a>
                </li>
                <li class=<?php _uri() ===  _route('auth_login') ? 'active' : '' ?>>
                    <a href="/authLogin.php">Connexion</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</header>