// Product Data
const products = [
  {
    name: "Solar Inverters",
    description:
      "Reliable and smart inverters that convert solar energy into usable electricity.",
    image: "assets/image/solar-home-solution.webp",
    link: "product-detail.html?product=solar-inverters", // 👈 your page
  },
  {
    name: "Solar Pumps",
    description:
      "Eco-friendly water pumping systems powered by solar energy, ideal for irrigation and rural water supply.",
    image: "assets/image/solar-micro-pump.webp",
    link: "product-detail.html?product=solar-pumps",
  },
  {
    name: "Photovoltaic Module Panels",
    description:
      "High-performance solar panels designed to capture maximum sunlight and generate clean energy efficiently.",
    image: "assets/image/solar-pv.jpg",
    link: "product-detail.html?product=photovoltaic-module-panels",
  },
];

// Target Grid Container
const productGrid = document.getElementById("productGrid");

// Generate Product Cards
products.forEach((product) => {
  const card = `
    <div class="rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
      <img src="${product.image}" alt="${product.name}" class="w-full h-56 object-cover">
      <div class="absolute inset-0"></div>
      <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-800">${product.name}</h3>
        <p class="text-gray-600 mt-2">${product.description}</p>
        <a href="${product.link}" class="mt-4 inline-block px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-800 transition">
          Read More
        </a>
      </div>
    </div>
  `;
  productGrid.innerHTML += card;
});
