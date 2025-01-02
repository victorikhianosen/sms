    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- @vite('resources/css/app.css') --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <title>{{ 'Novaji ' . $title ?? 'Novaji SMS' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        tailwind.config = {
            theme: {
                screens: {
                    sm: "480px",
                    md: "768px",
                    lg: "1020px",
                    xl: "1440px",
                },
                extend: {
                    colors: {
                        lightGray: "#F7F7F7",
                        softGray: "#939393",
                        black: "#000000",
                        white: "#ffffff",
                        gray: "#353535",
                        grayBg: "#f2f2f2",
                        blue: "#0152A8",
                        error: "#dc2626"
                    },
                    fontFamily: {
                        sans: ["Sora", "sans-serif"],
                    },
                },
            },
            plugins: [],
        };
    </script>