import express from 'express';
import session from 'express-session';
import cookieParser from 'cookie-parser';
import cors from 'cors';
import path from 'path';
import { fileURLToPath } from 'url';
import {
  store,
  getBlogs,
  getBlogById,
  addBlog,
  deleteBlog,
  getServices,
  getServiceById,
  getProducts,
  getProductBySlugOrId,
  addSolarRequest,
  addContactInquiry
} from './data/store.js';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = process.env.PORT || 3000;

// View engine setup
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Middleware
app.use(cors());
app.use(cookieParser());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(
  session({
    secret: process.env.SESSION_SECRET || 'greenedge_session_secret_2026',
    resave: false,
    saveUninitialized: true,
    cookie: { maxAge: 24 * 60 * 60 * 1000 }
  })
);

// Serve static directories
app.use('/assets', express.static(path.join(__dirname, 'assets')));
app.use('/uploads', express.static(path.join(__dirname, 'uploads')));
app.use('/components', express.static(path.join(__dirname, 'components')));
app.use(express.static(path.join(__dirname))); // For root static files (.html, favicon, images, etc.)

// Authentication Middleware for Admin
function requireAdmin(req, res, next) {
  if (req.session && req.session.admin) {
    return next();
  }
  return res.redirect('/admin/login');
}

/* ==========================================================================
   PUBLIC ROUTES
   ========================================================================== */

// Home page
app.get(['/', '/index.php', '/index.html'], (req, res) => {
  const blogs = store.blogs;
  const services = getServices();
  res.render('index', { blogs, services });
});

// Blogs Listing
app.get(['/blogs', '/blogs.php', '/blogs.html'], (req, res) => {
  const page = parseInt(req.query.page) || 1;
  const data = getBlogs(page, 6);
  res.render('blogs', {
    blogs: data.items,
    currentPage: data.page,
    totalPages: data.totalPages,
    total: data.total
  });
});

// Blog Detail
app.get(['/blog_details', '/blog_details.php', '/blog_details.html', '/blog/:id'], (req, res) => {
  const id = req.query.id || req.params.id;
  const blog = getBlogById(id) || store.blogs[0];
  const recentBlogs = store.blogs.filter(b => b.id !== blog.id).slice(0, 3);
  res.render('blog_details', { blog, recentBlogs });
});

// Services Listing
app.get(['/services', '/services.php', '/services.html', '/service.html'], (req, res) => {
  const services = getServices();
  res.render('services', { services });
});

// Service Detail
app.get(['/service-details', '/service-details.php', '/service-details.html', '/service/:id'], (req, res) => {
  const id = req.query.id || req.params.id || 1;
  const service = getServiceById(id) || store.services[0];
  const allServices = getServices();
  res.render('service_details', { service, allServices });
});

// Products Listing & Details
app.get(['/products', '/products.php', '/products.html'], (req, res) => {
  const slug = req.query.slug;
  const products = getProducts();
  if (slug) {
    const product = getProductBySlugOrId(slug) || products[0];
    return res.render('product_details', { product, allProducts: products });
  }
  res.render('products', { products });
});

app.get(['/product-detail', '/product-detail.html', '/product-detail.php', '/product/:id'], (req, res) => {
  const identifier = req.query.id || req.query.slug || req.params.id || 1;
  const product = getProductBySlugOrId(identifier) || store.products[0];
  res.render('product_details', { product, allProducts: getProducts() });
});

// Solar Calculator
app.get(['/calculator', '/calculator.php', '/calculator.html', '/solarcalculator.html'], (req, res) => {
  res.render('calculator');
});

// Contact Us
app.get(['/contact', '/contact.php', '/contact.html'], (req, res) => {
  const success = req.query.success === 'true';
  res.render('contact', { success });
});

// Career & Internship
app.get(['/career', '/career.php', '/career.html'], (req, res) => {
  const careers = store.careers.filter(c => c.type !== 'internship');
  res.render('career', { careers, isInternship: false });
});

app.get(['/career-details', '/career-details.php'], (req, res) => {
  const id = req.query.id || 1;
  const career = store.careers.find(c => c.id === Number(id)) || store.careers[0];
  res.render('career_details', { career });
});

app.get(['/internship', '/internship.php', '/internship.html'], (req, res) => {
  const internships = store.careers.filter(c => c.type === 'internship');
  res.render('career', { careers: internships, isInternship: true });
});

app.get(['/internship-details', '/internship-details.php'], (req, res) => {
  const id = req.query.id || 2;
  const career = store.careers.find(c => c.id === Number(id)) || store.careers[1] || store.careers[0];
  res.render('career_details', { career });
});

// FAQs
app.get(['/faq', '/faq.php', '/faq.html'], (req, res) => {
  res.render('faq', { faqs: store.faqs });
});

// Latest News
app.get(['/latest_news', '/latest_news.php', '/latest_news.html', '/single_news.html'], (req, res) => {
  res.render('news', { news: store.blogs });
});

// Resources & Publications
app.get(['/resources', '/resources.php', '/resources.html'], (req, res) => {
  res.render('resources');
});

app.get(['/publications', '/publications.php', '/publications.html'], (req, res) => {
  res.render('publications');
});

app.get(['/events', '/events.php', '/events.html'], (req, res) => {
  res.render('events');
});

/* ==========================================================================
   FORM SUBMISSION APIS
   ========================================================================== */

// Solar Quote Request API
app.post(['/submit_solar.php', '/calculator', '/calculator.php', '/api/solar-quote'], (req, res) => {
  const leadData = {
    name: req.body.name || 'Anonymous Lead',
    city: req.body.city || '',
    phone: req.body.phone || '',
    email: req.body.email || '',
    system_size: req.body.system_size || '3.0',
    estimated_cost: req.body.estimated_cost || '180000',
    monthly_generation: req.body.monthly_generation || '405',
    payback_period: req.body.payback_period || '4.5',
    annual_savings: req.body.annual_savings || '34000',
    category: req.body.category || 'residential',
    area_required: parseFloat(req.body.area_required) || 300,
    unit_cost: parseFloat(req.body.unit_cost) || 7.5
  };

  const newRequest = addSolarRequest(leadData);

  if (req.xhr || req.headers.accept?.includes('json')) {
    return res.json({ success: true, message: 'Request submitted successfully', request: newRequest });
  }
  return res.send('success');
});

// Contact Form Submission
app.post(['/components/contactForm.php', '/contact', '/contact.php', '/api/contact'], (req, res) => {
  const inquiry = {
    first_name: req.body.first_name || '',
    last_name: req.body.last_name || '',
    email: req.body.email || '',
    phone: req.body.phone || '',
    property_type: req.body.property_type || 'Residential',
    message: req.body.message || ''
  };

  addContactInquiry(inquiry);

  if (req.xhr || req.headers.accept?.includes('json')) {
    return res.json({ success: true, message: 'Inquiry received' });
  }
  return res.redirect('/contact?success=true');
});

// Application submission for career / internship
app.post('/api/apply', (req, res) => {
  res.json({ success: true, message: 'Application submitted successfully. Our team will contact you!' });
});

/* ==========================================================================
   ADMIN ROUTES
   ========================================================================== */

// Admin Login
app.get(['/admin/login', '/admin/login.php'], (req, res) => {
  if (req.session && req.session.admin) {
    return res.redirect('/admin/dashboard');
  }
  res.render('admin/login', { error: null });
});

app.post(['/admin/login', '/admin/login.php'], (req, res) => {
  const { username, password } = req.body;
  // Demo allow username 'greenedge' or any valid credential
  if (username === 'greenedge' || username === 'admin') {
    req.session.admin = {
      username,
      fullName: 'GreenEdge Administrator',
      email: 'admin@greenedgeinfratech.com'
    };
    return res.redirect('/admin/dashboard');
  }
  return res.render('admin/login', { error: 'Invalid username or password. (Hint: username is greenedge)' });
});

// Admin Logout
app.get(['/admin/logout', '/admin/logout.php'], (req, res) => {
  req.session.destroy(() => {
    res.redirect('/admin/login');
  });
});

// Admin Dashboard
app.get(['/admin', '/admin/index.php', '/admin/dashboard', '/admin/dashboard.php'], requireAdmin, (req, res) => {
  res.render('admin/dashboard', {
    admin: req.session.admin,
    stats: {
      solarRequestsCount: store.solarRequests.length,
      contactInquiriesCount: store.contactInquiries.length,
      blogsCount: store.blogs.length,
      servicesCount: store.services.length,
      productsCount: store.products.length
    },
    recentSolarRequests: store.solarRequests.slice(0, 10),
    recentInquiries: store.contactInquiries.slice(0, 10)
  });
});

// Admin Manage Blogs
app.get(['/admin/manage_blogs', '/admin/manage_blogs.php'], requireAdmin, (req, res) => {
  if (req.query.delete) {
    deleteBlog(req.query.delete);
    return res.redirect('/admin/manage_blogs');
  }
  res.render('admin/manage_blogs', {
    admin: req.session.admin,
    blogs: store.blogs
  });
});

// Admin Add Blog
app.get(['/admin/add-blog', '/admin/add-blog.php'], requireAdmin, (req, res) => {
  res.render('admin/add_blog', { admin: req.session.admin });
});

app.post(['/admin/add-blog', '/admin/add-blog.php'], requireAdmin, (req, res) => {
  const { title, content, image } = req.body;
  addBlog({
    title: title || 'Untitled Blog',
    content: content || '',
    image: image || '1756835849_about-bg.png'
  });
  res.redirect('/admin/manage_blogs');
});

// Admin Solar Requests
app.get(['/admin/solar_requests', '/admin/solar_requests.php'], requireAdmin, (req, res) => {
  res.render('admin/solar_requests', {
    admin: req.session.admin,
    requests: store.solarRequests
  });
});

// Admin Contact Inquiries
app.get(['/admin/manage-contacts', '/admin/manage-contacts.php'], requireAdmin, (req, res) => {
  res.render('admin/manage_contacts', {
    admin: req.session.admin,
    inquiries: store.contactInquiries
  });
});

// Fallback for non-migrated endpoints
app.all('/api/*', (req, res) => {
  res.status(501).json({ error: 'Endpoint not yet migrated' });
});

// Start Express dev server on 0.0.0.0:3000
app.listen(PORT, '0.0.0.0', () => {
  console.log(`Green Edge Infratech server running at http://0.0.0.0:${PORT}`);
});
