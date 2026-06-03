/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php"
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
