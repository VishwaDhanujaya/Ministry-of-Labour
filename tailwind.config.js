/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./includes/**/*.php",
    "./admin/**/*.php",
    "./admin/assets/js/**/*.js",
    "./assets/js/**/*.js",
    "!./vendor/**/*",
    "!./node_modules/**/*"
  ],
  theme: {
    extend: {
      colors: {
        primary: '#13273F',
        secondary: '#4E0000',
      },
      fontFamily: {
        montserrat: ['Montserrat', 'sans-serif'],
        inter: ['Inter', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
