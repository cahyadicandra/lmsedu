<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Asalink Edu</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                primary: "#4F46E5",
              },
              fontFamily: {
                sans: ["Roboto", "sans-serif"],
              }
            }
          }
        }
    </script>
    <style>
        .image-bg {
            background-image: url('/images/login_bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .gradient-header {
            background: linear-gradient(to right, #6366f1, #4F46E5);
        }
        .circle-checkbox {
            appearance: none;
            -webkit-appearance: none;
            background-color: transparent;
            border: 2px solid #9ca3af;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: inline-block;
            position: relative;
            cursor: pointer;
            margin-top: 2px;
        }
        .circle-checkbox:checked {
            border-color: #4F46E5;
        }
        .circle-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background-color: #4F46E5;
            border-radius: 50%;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-8 image-bg">
    
    <div class="w-full max-w-[420px] bg-white rounded-[2rem] overflow-hidden shadow-2xl relative border border-white/20">
        
        <!-- Top Header with Wave -->
        <div class="relative h-[220px] gradient-header">
            <!-- Wavy SVG shape -->
            <svg class="absolute bottom-0 w-full h-[60px]" preserveAspectRatio="none" viewBox="0 0 1440 320" style="margin-bottom: -1px;">
                <!-- We use two waves to create the overlay effect seen in the screenshot -->
                <path fill="#4F46E5" fill-opacity="0.3" d="M0,224L60,213.3C120,203,240,181,360,186.7C480,192,600,224,720,224C840,224,960,192,1080,170.7C1200,149,1320,139,1380,133.3L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
                <path fill="#ffffff" fill-opacity="1" d="M0,160L80,165.3C160,171,320,181,480,170.7C640,160,800,128,960,128C1120,128,1280,160,1360,176L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
            </svg>

            <!-- Logo -->
            <div class="absolute inset-0 flex flex-col items-center justify-center pb-12">
                <div class="mb-3 flex items-center justify-center">
                    <span class="material-symbols-outlined text-white" style="font-size: 56px;">school</span>
                </div>
                <h1 class="text-white font-bold text-xl tracking-[0.15em] uppercase">Asalink Edu</h1>
            </div>
        </div>

        <!-- Form Section -->
        <div class="px-8 pb-12 pt-2">
            <h2 class="text-[26px] font-bold text-center text-gray-700 mb-8 tracking-tight">Welcome back !</h2>

            @if($errors->any())
            <div class="bg-red-50 text-red-500 text-sm px-4 py-3 rounded-xl mb-6 text-center">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Alamat Email" class="w-full px-6 py-4 bg-[#f8f9fc] border-0 rounded-full text-[15px] focus:ring-2 focus:ring-primary/20 outline-none transition-all placeholder:text-gray-400 text-gray-700">
                </div>

                <div class="relative">
                    <input type="password" name="password" required placeholder="Password" class="w-full px-6 py-4 bg-[#f8f9fc] border-0 rounded-full text-[15px] focus:ring-2 focus:ring-primary/20 outline-none transition-all placeholder:text-gray-400 text-gray-700">
                    <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>



                <button type="submit" class="w-full mt-2 bg-transparent border border-primary text-primary hover:bg-primary/10 font-bold py-3.5 rounded-full transition-colors text-[17px]">
                    Login
                </button>
            </form>
        </div>
        
    </div>

</body>
</html>
