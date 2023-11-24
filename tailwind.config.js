const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './node_modules/flowbite/**/*.js',

    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },

        colors:{
            'green': '#0C4B05',
            'bar': '#989494',
            'light-green' : '#127507',
            'black' : 'black',
            'white': '#FFFFFF',
            'yellow': '#FFCD00',
            'gray': '#D9D9D9',
            'red' : '#de1900',
        },



    },

    plugins: [
        require('@tailwindcss/forms'),
        require('flowbite'),
        
    ],
    
};
