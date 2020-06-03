<?php
session_start();
    $Continents = [
        new Continent(1,'Americas','The Americas comprise the totality of the continents of North and South America.Together, they make up most of the land in Earths western hemisphere and comprise the New World'),
        new Continent(2,'Africa','Africa is the worlds second-largest and second-most populous continent, after Asia. At about 30.3 million km2 (11.7 million square miles) including adjacent islands, it covers 6% of Earths total surface area and 20% of its land area.'),
        new Continent(3,'Asia','Asia is Earths largest and most populous continent, located primarily in the Eastern and Northern Hemispheres.'),
        new Continent(4,'Oceania','Oceania is a geographic region that includes Australasia, Melanesia, Micronesia and Polynesia.'),
        new Continent(5,'Europa','Europe is a continent located entirely in the Northern Hemisphere and mostly in the Eastern Hemisphere.')
    ];

    if (isset($_SESSION["Continents"])) {
       $Continents = $_SESSION["Continents"];
    }
    
    if (!isset($_SESSION["Continents"])) {
        $_SESSION["Continents"] = [];
    }   
?>
