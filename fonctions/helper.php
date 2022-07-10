<?php

function nav_link(string $icone, string $lien, string $titre): string
{
    $activeBG = '';
    $activeText = '';
    $currentLinkController = str_replace('p=', '', $_SERVER['QUERY_STRING']);

    if (str_contains($currentLinkController, $lien)) {
        $activeBG = "  bg-primary text-white";
        $activeText = " text-white";
    }
    return <<<HTML
    <li class="nav-item $activeBG">
        <a href="index.php?p=$lien" class="nav-link font-italic text-dark $activeText">
            <i class="$icone text-primary $activeText"></i>
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

function convertDate(string $date, bool $heure = FALSE): string
{
    if ($heure === TRUE) {
        $heure = " à H:i";
    }
    $date = new DateTime($date);
    return $date->format('d/m/Y' . $heure);
}