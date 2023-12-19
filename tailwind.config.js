module.exports = {
  content: ['./public/**/*.{html,js,php}'],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        primary: '#158646',
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

