<?php
$baseDir = __DIR__;
$exportsDir = $baseDir . '/ui_exports';
$viewsDir = $baseDir . '/resources/views';
$layoutsDir = $viewsDir . '/layouts';

if (!is_dir($layoutsDir)) {
    mkdir($layoutsDir, 0777, true);
}

// 1. Read dashboard to extract layout
$dashboardPath = $exportsDir . '/dashboard_peserta_asalink_edu/code.html';
if (!file_exists($dashboardPath)) {
    die("Dashboard not found\n");
}
$htmlContent = file_get_contents($dashboardPath);

if (preg_match('/(<main[^>]*>)(.*?)(<\/main>)/is', $htmlContent, $matches, PREG_OFFSET_CAPTURE)) {
    $mainStartTag = $matches[1][0];
    
    $beforeMain = substr($htmlContent, 0, $matches[1][1]);
    $afterMain = substr($htmlContent, $matches[3][1]);
    
    $layoutContent = $beforeMain . $mainStartTag . "\n    @yield('content')\n" . $afterMain;
    
    file_put_contents($layoutsDir . '/app.blade.php', $layoutContent);
} else {
    die("Could not find <main> tag\n");
}

$routes = "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\n";

// 2. Extract contents for each page
$folders = glob($exportsDir . '/*', GLOB_ONLYDIR);
foreach ($folders as $folder) {
    $codeFile = $folder . '/code.html';
    if (file_exists($codeFile)) {
        $folderName = basename($folder);
        $viewName = str_replace('_asalink_edu', '', $folderName);
        $viewName = str_replace('_', '-', $viewName);
        
        $content = file_get_contents($codeFile);
        if (preg_match('/<main[^>]*>(.*?)<\/main>/is', $content, $matches)) {
            $innerContent = $matches[1];
            $bladeContent = "@extends('layouts.app')\n\n@section('content')\n" . $innerContent . "\n@endsection\n";
            file_put_contents($viewsDir . '/' . $viewName . '.blade.php', $bladeContent);
            
            $routePath = '/' . $viewName;
            if ($viewName === 'dashboard-peserta') {
                $routePath = '/';
            }
            
            $routes .= "Route::get('{$routePath}', function () {\n    return view('{$viewName}');\n});\n";
        }
    }
}

file_put_contents($baseDir . '/routes/web.php', $routes);
echo "Conversion complete.\n";
