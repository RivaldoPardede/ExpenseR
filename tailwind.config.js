module.exports = {
  content: [
              './public/**/*.{html,js,php}',
              "./node_modules/tw-elements/dist/js/**/*.js",
           ],
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
    require("tw-elements/dist/plugin.cjs")
  ],
}

