// FAQ Data (Add as many as you like)
  const faqs = [
    {
      question: "What is solar energy?",
      answer:
        "Solar energy is energy generated from the sun’s radiation. It is converted into electricity or used directly as heat to power homes, businesses, and other applications."
    },
    {
      question: "How does a solar system work?",
      answer:
        "Solar panels, made up of photovoltaic cells, capture sunlight and convert it into electricity. This electricity is then either used immediately (on grid) or stored in batteries (off grid) for later use."
    },
    {
      question: "What are the benefits of solar energy?",
      answer:
        "Solar energy is renewable, sustainable, and environmentally friendly. It reduces electricity bills, decreases dependence on fossil fuels, and contributes to a cleaner environment."
    },
    {
      question: "How long does it take to install a solar system?",
      answer:
        "The installation timeline varies depending on the size and complexity of the system. On average, residential installations typically take one to three days to complete."
    },
    {
      question: "Will my roof be able to support solar panels?",
      answer:
        "Most roofs can support solar panels. Our technicians will assess your roof’s condition and structural integrity during the site evaluation to ensure compatibility."
    },
    {
      question: "Do I need to obtain permits for solar installation?",
      answer:
        "Yes, permits are required for ongrid solar installations. The registration process for ongrid systems can be done through National Portal for Rooftop Solar by visiting the website <a href='https://pmsuryaghar.gov.in/#/' target='_blank' class='text-green-600 underline'>https://www.pmsuryaghar.gov.in/.</a> Our team will handle the permitting process, including obtaining necessary approvals from local authorities."
    },
    {
      question: "How much does a solar system cost?",
      answer:
        "The cost of a solar system depends on various factors such as system size, location, and equipment quality. We offer customized quotes tailored to each customer’s specific needs."
    },
    {
      question: "Are there financing options available for solar installation?",
      answer:
        "Yes, we offer several financing options, including solar loans, leasing, and power purchase agreements (PPAs). Our team can help you choose the best option based on your budget and preferences."
    },
    {
      question: "What maintenance is required for a solar system?",
      answer:
        "Solar panels require minimal maintenance. Periodic inspections and cleaning may be recommended to ensure optimal performance. Our team provides ongoing support and maintenance services."
    },
    {
      question: "What warranties are included with the solar system?",
      answer:
        "Our solar systems come with warranties covering equipment, including panels, inverters, and other components. Warranty terms vary by manufacturer and are discussed during the consultation process."
    },
    {
      question: "How does solar energy benefit the environment?",
      answer:
        "Solar energy reduces greenhouse gas emissions, air and water pollution, and reliance on nonrenewable energy sources. By choosing solar, you’re helping combat climate change and preserve natural resources."
    },
    {
      question: "Can solar energy be used in cloudy or rainy climates?",
      answer:
        "Yes, solar panels can still generate electricity on cloudy or rainy days, although at reduced efficiency. Modern solar technology is designed to capture diffuse sunlight and produce energy even in less-than-ideal conditions."
    },
    {
      question: "What is an off-grid solar system?",
      answer:
        "An off-grid solar system is a setup where solar panels generate electricity independently of the utility grid. This means the system is not connected to the main power grid, making it ideal for remote locations or areas with unreliable grid access."
    },
    {
      question: "How does an off-grid solar system work?",
      answer:
        "Off-grid solar systems work by capturing sunlight with solar panels, converting it into electricity through inverters, storing excess power in batteries, and using that stored energy to power your appliances and devices when sunlight is unavailable."
    },
    {
      question: "What size off-grid solar system do I need for my home/Institution/Industry?",
      answer:
        "The size of your off-grid solar system depends on factors such as your energy usage, location, available sunlight, and budget. A professional solar installer can assess your needs and recommend the appropriate system size for your specific requirements."
    },
    {
      question: "What is an on-grid solar system?",
      answer:
        "An on-grid solar system, also known as a grid-tied or grid-connected system, is a solar power generation setup that is connected to the local utility grid. This means it can draw power from the grid when needed and can also feed excess electricity back into the grid."
    },
    {
      question: "How does an on-grid solar system work?",
      answer:
        "During daylight hours, solar panels convert sunlight into electricity, which is then used to power your home or business. If the solar panels generate more electricity than you need, the excess is sent back into the grid, often resulting in credits or reduced electricity bills. When solar production is low, such as at night or during cloudy days, electricity is drawn from the grid as usual."
    },
    {
      question: "What are the benefits of an on-grid solar system?",
      answer:
        `
      <ul class="list-disc pl-5 space-y-2">
        <li><strong>Lower electricity bills:</strong> By generating your own electricity, you can reduce your reliance on the grid and lower your monthly electricity bills.</li>
        <li><strong>Environmental impact:</strong> Solar power is clean and renewable, helping to reduce greenhouse gas emissions and combat climate change.</li>
        <li><strong>Financial incentives:</strong> Government offer financial incentives, in the form of subsidy for installing solar panels.</li>
        <li><strong>Grid stability:</strong> On-grid systems help stabilize the grid by reducing peak demand and providing additional sources of electricity.</li>
      </ul>
    `
    },
    {
      question: "Do I need batteries with an on-grid solar system?",
      answer:
        "No, batteries are not required for an on-grid solar system. However, you may choose to install batteries as part of a backup power solution or to further reduce your reliance on the grid during times of high demand or power outages."
    },
    {
      question: "How much space do I need for solar panels?",
      answer:
        "The amount of space required depends on factors such as your energy consumption, the efficiency of the solar panels, and the available sunlight in your area. Our team can assess your specific needs and recommend the appropriate size and configuration of solar panels for your property."
    }
  ];

  // Target container
  const faqContainer = document.getElementById('faqAccordion');

  // Render FAQs
  faqContainer.innerHTML = faqs.map(faq => `
    <div class="border-b">
      <button class="w-full flex justify-between items-center py-4 text-left text-lg font-medium accordion-btn">
        <span>${faq.question}</span>
        <svg class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div class="accordion-content hidden pb-4 text-gray-700">
        ${faq.answer}
      </div>
    </div>
  `).join('');

  // Accordion toggle behavior
  document.querySelectorAll('.accordion-btn').forEach(button => {
    button.addEventListener('click', () => {
      const content = button.nextElementSibling;
      const icon = button.querySelector('svg');

      content.classList.toggle('hidden');
      icon.classList.toggle('rotate-180');
    });
  });