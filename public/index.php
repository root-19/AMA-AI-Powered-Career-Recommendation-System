<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AMA AI-Powered Career Recommendation System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <style>
    .fade-in {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 1s ease-out, transform 1s ease-out;
    }
    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .hover-glow:hover {
      box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
    }
    .floating {
      animation: floating 3s ease-in-out infinite;
    }
    @keyframes floating {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }
    .text-gradient {
      background: linear-gradient(45deg, #3b82f6, #60a5fa);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
  <div id="welcomeBox" class="fade-in max-w-4xl w-full text-center p-12 space-y-8" data-aos="fade-up" data-aos-duration="1000">
    <div class="space-y-4">
      <h1 class="text-5xl md:text-6xl font-black text-gradient tracking-tight">Welcome to</h1>
      <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">AMA AI-Powered Career<br/>Recommendation System</h2>
    </div>
    
    <p class="text-gray-700 text-lg md:text-xl mt-4 leading-relaxed max-w-xl mx-auto">
      Let AI guide you to the perfect career path. Personalized insights based on your unique strengths and aspirations.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
      <div class="bg-gray-50 p-6 rounded-xl hover-glow" data-aos="fade-up" data-aos-delay="100">
        <div class="text-blue-600 text-2xl mb-3">🎯</div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Smart Matching</h3>
        <p class="text-gray-600">Our advanced AI analyzes your skills, interests, and personality to find your ideal career match.</p>
      </div>
      
      <div class="bg-gray-50 p-6 rounded-xl hover-glow" data-aos="fade-up" data-aos-delay="200">
        <div class="text-blue-600 text-2xl mb-3">📊</div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Market Insights</h3>
        <p class="text-gray-600">Get real-time data on job market trends, salary expectations, and growth opportunities.</p>
      </div>
      
      <div class="bg-gray-50 p-6 rounded-xl hover-glow" data-aos="fade-up" data-aos-delay="300">
        <div class="text-blue-600 text-2xl mb-3">🚀</div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Career Roadmap</h3>
        <p class="text-gray-600">Receive a personalized development plan with actionable steps to achieve your career goals.</p>
      </div>
    </div>

    <div class="mt-12 bg-gray-50 p-8 rounded-xl" data-aos="fade-up" data-aos-delay="400">
      <h3 class="text-2xl font-bold text-gray-900 mb-4">Why Choose Our Platform?</h3>
      <ul class="space-y-3 text-gray-700">
        <li class="flex items-center">
          <span class="text-blue-600 mr-2">✓</span>
          Powered by cutting-edge AI technology
        </li>
        <li class="flex items-center">
          <span class="text-blue-600 mr-2">✓</span>
          Backed by industry experts and career counselors
        </li>
        <li class="flex items-center">
          <span class="text-blue-600 mr-2">✓</span>
          Regular updates with latest market trends
        </li>
        <li class="flex items-center">
          <span class="text-blue-600 mr-2">✓</span>
          Personalized recommendations and insights
        </li>
      </ul>
    </div>

    <div class="mt-8 space-y-4">
      <a href="/register" class="inline-block text-white bg-blue-600 hover:bg-blue-700 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 hover-glow transform hover:scale-105 floating">
        Get Started →
      </a>
      <p class="text-sm text-gray-500 mt-4">Join thousands of successful professionals</p>
    </div>
  </div>

  <script>
    AOS.init();
    window.addEventListener('DOMContentLoaded', () => {
      const box = document.getElementById('welcomeBox');
      setTimeout(() => box.classList.add('visible'), 200);
    });
  </script>
</body>
</html>
