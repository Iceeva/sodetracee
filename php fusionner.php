<?php
$directory = "C:\wamp64\www\sodetracee";
$outputFile = "contenu_projet.txt";

// Ouvre le fichier pour écrire
$output = fopen($outputFile, "w");

// Parcourt tous les fichiers du projet
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() == "php") {
        $content = file_get_contents($file->getRealPath());
        fwrite($output, "=== " . $file->getFilename() . " ===\n");
        fwrite($output, $content . "\n\n");
    }
}

fclose($output);
echo "Contenu fusionné dans $outputFile";
?>
