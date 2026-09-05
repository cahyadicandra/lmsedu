<?php

$viewsDir = __DIR__ . '/resources/views';
$dashboardFile = $viewsDir . '/dashboard-peserta.blade.php';
$componentsDir = $viewsDir . '/components/dashboard';

if (!is_dir($componentsDir)) {
    mkdir($componentsDir, 0777, true);
}

$content = file_get_contents($dashboardFile);

// Helper to extract a block
function extractBlock($startComment, $endComment, &$content, $componentName) {
    global $componentsDir;
    $startPos = strpos($content, $startComment);
    if ($startPos === false) return false;
    
    // Find where the next sibling comment or end of section is, this is tricky.
    // Instead of regex, we'll do manual matching based on known structure.
    return true; // We'll do it manually below since it's safer
}

// Since doing it purely by regex is risky, let's just create the component files and put the hardcoded sections in them directly.
// Actually, it's better if I just use regex to match the exact HTML blocks based on the previous view_file output.

$parts = explode('<!-- 1. Welcome Hero Banner Card -->', $content);
$beforeBanner = $parts[0];
$rest = $parts[1];

$parts = explode('<!-- 2. Performance Section ("Performa Belajar") -->', $rest);
$banner = $parts[0];
$rest = $parts[1];

$parts = explode('<!-- 3. Tutor & Mentor Pembimbing ("Tutor Pendamping") -->', $rest);
$performance = $parts[0];
$rest = $parts[1];

$parts = explode('<!-- RIGHT CALENDAR & SCHEDULE RAIL (xl:col-span-4) -->', $rest);
$mentors = $parts[0];
$rest = $parts[1];

$parts = explode('<!-- 4. Daily Schedule Timeline ("Jadwal Hari Ini") -->', $rest);
$beforeRail = $parts[0];
$rest = $parts[1];

$parts = explode('<!-- 5. Upcoming Events & Webinar ("Agenda & Webinar Asalink") -->', $rest);
$schedule = $parts[0];
$rest = $parts[1];

$parts = explode('<!-- Bottom Quick Links & Project Shortcut Strip -->', $rest);
$events = $parts[0];
$bottomLinks = $parts[1];

// Write components
file_put_contents($componentsDir . '/welcome-banner.blade.php', trim($banner));
file_put_contents($componentsDir . '/performance-section.blade.php', trim($performance));
file_put_contents($componentsDir . '/mentors.blade.php', trim($mentors));
file_put_contents($componentsDir . '/daily-schedule.blade.php', trim($schedule));

// The events section contains a closing </div></div> which belongs to the layout.
// Let's strip the closing tags from $events and put them in the main file.
$events = trim($events);
// If it ends with </div></div>, we should be careful.
// Let's find the reference image attachment and closing tags.
$parts = explode('<!-- Reference Image Attachment for fidelity audit -->', $events);
if (count($parts) > 1) {
    // The events block actually doesn't contain it, the bottomLinks contains it!
}

$parts = explode('<!-- Reference Image Attachment for fidelity audit -->', $bottomLinks);
$quickLinks = trim($parts[0]);
$footerTags = '<!-- Reference Image Attachment for fidelity audit -->' . $parts[1];

file_put_contents($componentsDir . '/upcoming-events.blade.php', $events);
file_put_contents($componentsDir . '/quick-links.blade.php', $quickLinks);

// Reconstruct dashboard-peserta.blade.php
$newDashboard = $beforeBanner . 
"<!-- 1. Welcome Hero Banner Card -->\n" .
"<x-dashboard.welcome-banner :user=\"\$user\" />\n\n" .
"<!-- 2. Performance Section -->\n" .
"<x-dashboard.performance-section />\n\n" .
"<!-- 3. Tutor & Mentor Pembimbing -->\n" .
"<x-dashboard.mentors />\n\n" .
$beforeRail .
"<!-- 4. Daily Schedule Timeline -->\n" .
"<x-dashboard.daily-schedule :schedules=\"\$schedules\" />\n\n" .
"<!-- 5. Upcoming Events & Webinar -->\n" .
"<x-dashboard.upcoming-events />\n\n" .
"<!-- Bottom Quick Links & Project Shortcut Strip -->\n" .
"<x-dashboard.quick-links />\n\n" .
$footerTags;

file_put_contents($dashboardFile, $newDashboard);

echo "Components extracted successfully.\n";
