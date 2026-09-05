import os
import re
import glob

base_dir = r"d:\Joki\Kasir\lmsedu"
exports_dir = os.path.join(base_dir, "ui_exports")
views_dir = os.path.join(base_dir, "resources", "views")
layouts_dir = os.path.join(views_dir, "layouts")

os.makedirs(layouts_dir, exist_ok=True)

# 1. Read dashboard to extract layout
dashboard_html_path = os.path.join(exports_dir, "dashboard_peserta_asalink_edu", "code.html")
with open(dashboard_html_path, 'r', encoding='utf-8') as f:
    html_content = f.read()

# The layout is basically:
# Everything before <main class="...">
# Then @yield('content')
# Then </main></div></body></html>

main_match = re.search(r'(<main[^>]*>)(.*?)(</main>)', html_content, re.DOTALL)
if main_match:
    main_start_tag = main_match.group(1)
    
    before_main = html_content[:main_match.start(1)]
    after_main = html_content[main_match.end(2):]
    
    layout_content = before_main + main_start_tag + "\n    @yield('content')\n" + after_main
    
    # Let's fix active states in layout: replace hardcoded aria-current and active classes with blade logic later if needed.
    # For now, just save layout
    with open(os.path.join(layouts_dir, "app.blade.php"), "w", encoding='utf-8') as f:
        f.write(layout_content)
else:
    print("Could not find <main> tag in dashboard")
    exit(1)

routes = ["<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n"]

# 2. Extract contents for each page
for folder in glob.glob(os.path.join(exports_dir, "*")):
    if os.path.isdir(folder):
        code_file = os.path.join(folder, "code.html")
        if os.path.exists(code_file):
            folder_name = os.path.basename(folder)
            
            # Create a simple view name
            view_name = folder_name.replace('_asalink_edu', '').replace('_', '-')
            
            with open(code_file, 'r', encoding='utf-8') as f:
                content = f.read()
            
            match = re.search(r'<main[^>]*>(.*?)</main>', content, re.DOTALL)
            if match:
                inner_content = match.group(1)
                
                blade_content = f"@extends('layouts.app')\n\n@section('content')\n{inner_content}\n@endsection\n"
                with open(os.path.join(views_dir, f"{view_name}.blade.php"), "w", encoding='utf-8') as f:
                    f.write(blade_content)
                
                # Add route
                route_path = f"/{view_name}"
                if view_name == 'dashboard-peserta':
                    route_path = '/'
                
                routes.append(f"Route::get('{route_path}', function () {{\n    return view('{view_name}');\n}});\n")

with open(os.path.join(base_dir, "routes", "web.php"), "w", encoding='utf-8') as f:
    f.write("".join(routes))

print("Conversion complete.")
