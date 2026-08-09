const whyItems = [
  {
    title: "Innovation And Research",
    summary:
      "Solar energy is driving innovation and research in the energy sector, leading to new technologies, products, and services that support sustainability and help combat climate change. Continuous advancements make solar energy one of the most dynamic fields today.",
    more: "Researchers are continuously working on increasing solar efficiency, developing storage technologies, and integrating solar with smart grids to make energy usage more reliable and affordable.",
  },
  {
    title: "Economics",
    summary:
      "Solar energy is becoming more cost-effective and is driving economic growth worldwide. As panel costs decrease and efficiency improves, more businesses and individuals are turning to solar as a sustainable energy solution.",
    more: "Governments also provide tax incentives and subsidies, making solar a smart financial decision while reducing long-term electricity expenses significantly.",
  },
  {
    title: "Sustainability (Health, Safety, Environment)",
    summary:
      "Solar power supports sustainability by reducing harmful emissions, protecting health, and promoting clean air and water. It contributes to building healthier and safer communities for the future.",
    more: "Unlike fossil fuels, solar energy doesn’t release harmful pollutants, making it a clean and safe option for communities while promoting long-term ecological balance.",
  },
  {
    title: "Need of the Hour",
    summary:
      "With rising global warming and energy crises, transitioning to renewable sources is essential. Solar energy offers a sustainable solution to reduce dependency on fossil fuels and combat climate change.",
    more: "The urgency to adopt renewable energy is greater than ever, as fossil fuel dependency not only accelerates climate change but also threatens energy security globally.",
  },
];

const container = document.getElementById("why-solar");

container.innerHTML = whyItems
  .map(
    (item) => `
        <div class="why-item">
          <h3 class="text-2xl font-bold text-green-700">${item.title}</h3>
          <p class="text-gray-700 mt-3">${item.summary}</p>
          <p class="extra-content text-gray-700 mt-3 hidden">${item.more}</p>
          <button class="read-more-btn mt-4 px-5 py-2 bg-green-700 text-white rounded-md hover:bg-green-800 transition">
            Read more
          </button>
        </div>
      `
  )
  .join("");

// Toggle read more/less
document.querySelectorAll(".read-more-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    const extraContent = this.parentElement.querySelector(".extra-content");
    if (extraContent) {
      extraContent.classList.toggle("hidden");
      this.textContent = extraContent.classList.contains("hidden")
        ? "Read more"
        : "Read less";
    }
  });
});
