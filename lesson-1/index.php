<?php
$dir = new RecursiveDirectoryIterator(isset($_GET["path"]) ? $_GET["path"] : "C:");

foreach ($dir as $item) {
    $path = $item->getPathname();
    echo $item->isDir() ? "<a href=?path=$path>" . $item->getFilename() . '</a><br>' : $item->getFilename() . '<br>';
}