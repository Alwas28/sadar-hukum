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
                sans:    ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', 'serif'],
            },

            colors: {
                // Hijau – warna pohon & alam pada logo
                hijau: {
                    50:  '#f0faf4',
                    100: '#d9f2e3',
                    200: '#b3e4c8',
                    300: '#7dcca6',
                    400: '#45ad7e',
                    500: '#1f8f60',
                    600: '#13734b',
                    700: '#0f5c3c',
                    800: '#0c4830',
                    900: '#093826',
                },
                // Emas – border & daun pada logo
                emas: {
                    300: '#fde68a',
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#d97706',
                },
                // Langit – warna perisai biru pada logo
                langit: {
                    50:  '#ebf5fb',
                    100: '#cfe8f7',
                    200: '#9fd2ef',
                    300: '#6fbce7',
                    400: '#3fa6df',
                    500: '#2b8fc8',
                    600: '#2272a3',
                    700: '#1a577e',
                    800: '#123d59',
                    900: '#0a2235',
                },
            },

            animation: {
                'fade-up': 'fadeUp 0.5s ease forwards',
            },
            keyframes: {
                fadeUp: {
                    '0%':   { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
