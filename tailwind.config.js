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
                rs: {
                    primary: '#0564F5',
                    'primary-dark': '#0449C4',
                    'primary-light': '#639AE9',
                    accent: '#639AE9',
                    'accent-dark': '#0449C4',
                    success: '#8BC97F',
                    warning: '#F4B266',
                    emergency: '#EA4758',
                    'emergency-dark': '#C73545',
                    'emergency-light': '#FCE8EB',
                    background: '#EFEFEF',
                    surface: '#FFFFFF',
                    border: '#C5C4C5',
                    'text-primary': '#2B2C2E',
                    'text-secondary': '#9C9D9E',
                    launcher: '#E8EEF5',
                },
            },
        },
    },

    plugins: [forms],
};
