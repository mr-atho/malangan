import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                navy: '#09090B', // Obsidian Charcoal
                gold: '#C5A880', // Champagne Gold
                'cod-gray': '#18181B', // Zinc-900
                'spicy-pink': '#B0936B', // Muted Dark Gold
                'cream': '#FAF9F6', // Ivory White
            },
        },
    },

    safelist: [
        { pattern: /bg-(yellow|blue|indigo|green|red|gray|emerald|amber|purple)-100/ },
        { pattern: /text-(yellow|blue|indigo|green|red|gray|emerald|amber|purple)-700/ },
        { pattern: /text-(yellow|blue|indigo|green|red|gray|emerald|amber|purple)-600/ },
        { pattern: /border-(yellow|blue|indigo|green|red|gray|emerald|amber|purple)-200/ },
    ],

    plugins: [forms],
};
