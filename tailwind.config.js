import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    // plugins: [forms, typography],
    plugins: [require("daisyui")],
    daisyui: {
      themes: 'light',
    },
    darkMode: false,

    safelist: [
      'w-20', 'h-20', 'bg-red-400', 'rounded-full', 'bg-green-400', 'w-28', 'h-16', 'bg-yellow-400', 'bg-gray-400'
    ],
};
