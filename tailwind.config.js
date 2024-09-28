module.exports = {
  content: [
    // https://tailwindcss.com/docs/content-configuration
    "./*.{php,html,js}",
    "./template-parts/*.{php,html,js}",
    "./blocks/*.{php,html,js}",
    "./blocks/**/*.{php,html,js}",
    "./*.php",
    "./inc/**/*.php",
    "./templates/**/*.php",
    "./safelist.txt",

    //'./**/*.php', // recursive search for *.php (be aware on every file change it will go even through /node_modules which can be slow, read doc)
  ],
  safelist: [
    "text-center",
    //{
    //  pattern: /text-(white|black)-(200|500|800)/
    //}
  ],
  theme: {
    fontSize: {
      sm: "0.8rem",
      base: "1rem",
      lg: "1.125rem",
      xl: "1.25rem",
      "2xl": "1.563rem",
      "3xl": "1.625rem",
      "4xl": "2rem",
      "5xl": "3.25rem",
      "6xl": "4.5rem",
    },

    extend: {
      colors: {
        primary: {
          100: "#3A75BD",
          200: "#262AAB",
          300: "#0C3D79",
          400: "#11388C",
        },
        secondary: {
          100: "#FDFF86",
          200: "#FBFF40",
        },
        accent: {
          100: "#FAC279",
          200: "#F49B2A",
        },
        neutro: {
          100: "#D7D7D7",
          200: "#9D9D9D",
        },
        text: "#0A2E78",
      },
    },
  },
  plugins: [],
};
