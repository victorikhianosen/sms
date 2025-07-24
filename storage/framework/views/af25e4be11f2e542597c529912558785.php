    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="https://cdn.tailwindcss.com"></script>
        


    <title><?php echo e('GGT ' . $title ?? 'GGT SMS'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">




    <!-- Prism.js CSS (you can choose a theme) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    <!-- Prism.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>




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
                        textPrimary: "#4d4d4d",
                        textSecondary: "#9FA19F",
                        grayBg: "#f2f2f2",
                        blue: "#0B163F",
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
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/includes/header.blade.php ENDPATH**/ ?>