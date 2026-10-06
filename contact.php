<?php
// Yeh sabse top par hona chahiye, HTML tag se pehle!
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - GreenEdge Infratech</title>
    <meta name="description" content="Contact GreenEdge Infratech for customized solar rooftop installations, energy solutions, and consultations in Aligarh, Uttar Pradesh. Call +91 98370 67681.">
    <link rel="canonical" href="https://greenedgeinfratech.com/contact" />
    <link rel="icon" href="assets/image/favicon.ico" type="image/x-icon">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://greenedgeinfratech.com/contact" />
    <meta property="og:title" content="Contact Us - GreenEdge Infratech" />
    <meta property="og:description" content="Contact GreenEdge Infratech for customized solar rooftop installations, energy solutions, and consultations in Aligarh, Uttar Pradesh." />
    <meta property="og:image" content="https://greenedgeinfratech.com/assets/logo.png" />
    <meta property="og:site_name" content="GreenEdge Infratech" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11515555005"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'AW-11515555005');
    </script>
</head>

<body class="font-sans text-gray-800 bg-gray-50">

    <div id="header"></div>

    <section class="relative py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-800">Contact Us</h1>
                <p class="text-gray-600 mt-4">We’re here to answer your questions and help your projects move forward.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-green-600 text-white rounded-full">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800">Our Office</h4>
                            <p class="text-gray-600">opp. BJP office Kayampur, Asadpur Kayam, Aligarh, Uttar Pradesh 202001</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-green-600 text-white rounded-full">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800">Call Us</h4>
                            <p class="text-gray-600">+91 98370 67681</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-green-600 text-white rounded-full">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800">Email Us</h4>
                            <p class="text-gray-600">greenedgeinfratech@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <?php include("components/contactForm.php") ?>
                </div>
            </div>

            <div class="mt-16">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3526.437001589913!2d78.1123739!3d27.8885599!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3974a416db4c70e5%3A0x44bdc39eb3b0a09c!2sGREENEDGE%20SOLAR!5e0!3m2!1sen!2sin!4v1755944911133!5m2!1sen!2sin"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    
    <?php if(isset($success) && $success == true): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const popup = document.createElement("div");
            popup.innerHTML = `
                <div style="
                    position:fixed;
                    top:0; left:0;
                    width:100%; height:100%;
                    background:rgba(0,0,0,0.6);
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    z-index:9999;">
                    
                    <div style="
                        background:white;
                        padding:30px;
                        border-radius:10px;
                        text-align:center;
                        max-width:400px;">
                        
                        <h2 style="color:green;">✅ Message Sent Successfully!</h2>
                        <p>Thank you for contacting GreenEdge Infratech.<br>We will reach out to you shortly.</p>
                        <button onclick="this.closest('div').parentElement.remove()"
                            style="
                            margin-top:15px;
                            padding:10px 20px;
                            background:green;
                            color:white;
                            border:none;
                            border-radius:5px;
                            cursor:pointer;">
                            Close
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(popup);
        });
    </script>
    <?php endif; ?>

    <div id="footer"></div>

    <script src="./assets/js/component.js"></script>

</body>

</html>