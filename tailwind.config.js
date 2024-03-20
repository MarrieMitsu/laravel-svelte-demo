/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.{html,js,svelte,ts}",
    ],
    theme: {
        extend: {},
    },
    daisyui: {
        "themes": ["nord"],
    },
    plugins: [require("@tailwindcss/typography"), require("daisyui")],
}

