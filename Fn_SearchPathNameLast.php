<?php
function PDFNamePathLast($folderPath) {
    $files = scandir($folderPath);
    $pdfFiles = array_filter($files, function($file) {
        return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
    });
    $latest = '';
    $latestTimestamp = 0;
    foreach ($pdfFiles as $pdfFile) {
        $filePath = $folderPath . $pdfFile;
        $timestamp = filemtime($filePath);

        if ($timestamp > $latestTimestamp) {
            $latestTimestamp = $timestamp;
            $latest = $pdfFile;
        }
    }
    if (!empty($latest)) {
        $PathDefaultPDF = $folderPath . $latest;
    } else {
        $PathDefaultPDF = '#';
    }
    return $PathDefaultPDF;
}
?>