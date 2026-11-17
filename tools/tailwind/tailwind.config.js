/** Tailwind build for greenedgeinfratech.com
 *  Rebuild after editing page markup:
 *    npx tailwindcss@3 -c tools/tailwind/tailwind.config.js -i tools/tailwind/input.css -o assets/css/site.css --minify
 *  (run from the repository root)
 */
module.exports = {
  content: [
    './*.php', './inc/**/*.php', './pmsuryaghar/**/*.php', './manage/**/*.php',
    './assets/js/calculator.js', './assets/js/site.js',
  ],
  theme: {
    container: { center: true },
    extend: {
      maxWidth: { prose: '72ch' },
    },
  },
  plugins: [],
};
