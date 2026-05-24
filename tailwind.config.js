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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                navy: '#1B4332',
                gold: '#D4C5A9',
                'cod-gray': '#0D1F18',
                'spicy-pink': '#6B8F71',
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
