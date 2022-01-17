<?php

function nav_link(string $icone, string $lien, string $titre): string
{
    $currentURL = array_filter(explode('/', $_SERVER['REQUEST_URI']));
    $active = "";
    $lien = '/'.$lien;
    if ($lien === $currentURL) {
        $active = "bg-light";
    }
    return <<<HTML
    <li class="nav-item">
        <a href="$lien" class="nav-link text-dark font-italic $active">
            <i class="$icone text-primary"></i>
            $titre
        </a>
    </li>
HTML;
}

function includeCSS(string $nomFichier): string
{
    return "<link rel='stylesheet' href='../CSS/$nomFichier.css'>";
}