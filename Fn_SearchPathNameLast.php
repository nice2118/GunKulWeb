<?php
function PDFNamePathLast($folderPath) {
    $isLink = filter_var($folderPath, FILTER_VALIDATE_URL);
    
    if (!$isLink) {
        // ตรวจสอบว่าโฟลเดอร์นี้มีอยู่หรือไม่ ถ้าไม่มีให้สร้างโฟลเดอร์
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
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
    } else {
        $PathDefaultPDF = $isLink;
    }
    return $PathDefaultPDF;
}
?>