<?php

function nav_link(string $icone, string $lien, string $titre): string
{
    $currentURL = array_filter(explode('/', $_SERVER['REQUEST_URI']));
    $active = "";
    if ($lien === $currentURL) {
        $active = "bg-light";
    }
    return <<<HTML
    <li class="nav-item">
        <a href="index.php?p=$lien" class="nav-link text-dark font-italic $active">
            <i class="$icone text-primary"></i>
            $titre
        </a>
    </li>
HTML;
}

function keepInputValue(string $variable): string
{
    if (!isset($erreurs[$variable])) {
        return htmlentities($_POST[$variable] ?? '');
    }
}