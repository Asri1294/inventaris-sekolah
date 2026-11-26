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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                indigo: {
                    50: '#f0f5fa',
                    100: '#dde8f3',
                    200: '#bfd3e8',
                    300: '#94b4d5',
                    400: '#6b92bf',
                    500: '#4d77a8',
                    600: '#3d6190',
                    700: '#334f76',
                    800: '#2d4260',
                    900: '#28384f',
                    950: '#1a2535',
                },
            },
        },
    },

    plugins: [forms],
};
