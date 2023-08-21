<?php
function PDFNamePathLast($folderPath) {
    $isLink = filter_var($folderPath, FILTER_VALIDATE_URL);
    
    if (!$isLink) {
        // ตรวจสอบว่า $folderPath มีเครื่องหมาย / ที่สุดท้ายหรือไม่
        if (substr($folderPath, -1) !== '/') {
            $folderPath .= '/';
        }

        // ตรวจสอบว่าโฟลเดอร์นี้มีอยู่หรือไม่ ถ้าไม่มีให้สร้างโฟลเดอร์
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $files = scandir($folderPath);
        // $filteredFiles = array_filter($files, function($file) {
        //     // return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
        // });
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
        $filteredFiles = array_filter($files, function($file) use ($allowedExtensions) {
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
            return in_array($fileExtension, $allowedExtensions);
        });

        $latest = '';
        $latestTimestamp = 0;
        foreach ($filteredFiles as $filteredFile) {
            $filePath = $folderPath . $filteredFile;
            $timestamp = filemtime($filePath);
    
            if ($timestamp > $latestTimestamp) {
                $latestTimestamp = $timestamp;
                $latest = $filteredFile;
            }
        }
        if (!empty($latest)) {
            $PathDefault = $folderPath . $latest;
        } else {
            $PathDefault = '#';
        }
    } else {
        $PathDefault = $isLink;
    }
    return $PathDefault;
}
?>