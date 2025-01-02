/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
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
                blue: "#0152A8",
            },
            fontFamily: {
                sans: ["Sora", "sans-serif"],
            },
        },
    },
    plugins: [],
};
