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
                sans: ['"Plus Jakarta Sans"', 'Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#fdf2f4',
                    100: '#fbe8ea',
                    200: '#f7d5d8',
                    300: '#f0b3b9',
                    400: '#e4808a',
                    500: '#d14d5c',
                    600: '#b73243',
                    700: '#991b2b',
                    800: '#8b1525',
                    900: '#670014',
                    950: '#3b000a',
                },
                smecone: {
                    maroon: '#8b1525',
                    gold: '#f59e0b',
                    blue: '#0284c7',
                    surface: '#f8fafc',
                },
            },
        },
    },

    plugins: [forms],
};
