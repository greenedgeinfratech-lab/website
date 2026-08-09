const newsItems = [
  {
    title: "Latest News",
    summary:
      "Stay up-to-date with the latest developments at Greenedge Infratech! Our Latest News section brings you exciting updates about our solar projects, innovative technologies, and sustainability initiatives. From new installations and partnerships to government policy changes and industry trends, this is your source for all things solar. Be inspired by our journey as we work towards …",
    link: "single_news.html" // 👈 link to full page
  },
];

const container = document.getElementById("latestNews");

container.innerHTML = newsItems
  .map(
    (item) => `
        <div class="why-item">
          <h3 class="text-2xl font-bold text-green-700">${item.title}</h3>
          <p class="text-gray-700 mt-3">${item.summary}</p>
          <a href="${item.link}" class="mt-4 inline-block px-5 py-2 bg-green-700 text-white rounded-md hover:bg-green-800 transition">
            Read more
          </a>
        </div>
      `
  )
  .join("");


