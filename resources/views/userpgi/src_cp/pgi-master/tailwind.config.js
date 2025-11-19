import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        "./resources/**/*.js",
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                transparent: 'transparent',
                'first-blue': '#FF4500',
                'first-orange': '#068F7D',
                "maquette-gris" : "#f5f5f5",
                "arriere": "#F8F8F8",
                "orange-clair": "#f7ac42",
                "orange-foncé": "#E38E18",


            },
            backgroundImage: {
                'side': "url('/public/loginAssets/images/backgroundImg.svg')",
                'a': "url('/public/assets/images/a.jpeg')",
                'b': "url('/public/assets/images/b.jpeg')",
                'c': "url('/public/assets/images/c.jpeg')",
                'd': "url('/public/assets/images/d.jpeg')",
                'f': "url('/public/assets/images/f.jpeg')",
                'aa': "url('/public/assets/images/a.png')",
                'bb': "url('/public/assets/images/b.png')",
                'cc': "url('/public/assets/images/c.png')",
                'ee': "url('/public/assets/images/e.png')",
                'ff': "url('/public/assets/images/f.png')",
                'gg': "url('/public/assets/images/c.png')",
              },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            spacing: {
                // You can define a negative margin utility here
                '-8': '-8%',
              },
        },
    },

    plugins: [
        require('flowbite/plugin'),
        forms, typography],
};
