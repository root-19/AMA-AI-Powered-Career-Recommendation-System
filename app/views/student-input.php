<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data Input - AMA Career Recommendation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.1);
        }
        .progress-bar {
            transition: width 0.5s ease-in-out;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen text-gray-800">
    <?php require_once __DIR__ . '/layouts/header.php'; ?>

    <main class="max-w-4xl mx-auto py-10 px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="fade-up">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-900">Student Profile Input</h1>
            
            <!-- Progress Bar -->
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
                <div class="progress-bar bg-red-600 h-2.5 rounded-full" style="width: 0%"></div>
            </div>

            <form id="studentForm" class="space-y-8" action="/process-student-data" method="POST">
                <!-- Academic Performance -->
                <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-xl font-semibold text-gray-900">Academic Performance</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">GPA (0-4.0)</label>
                            <input type="number" step="0.01" min="0" max="4" name="gpa" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Academic Level</label>
                            <select name="academic_level" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                <option value="">Select Level</option>
                                <option value="high_school">High School</option>
                                <option value="undergraduate">Undergraduate</option>
                                <option value="graduate">Graduate</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Personal Interests -->
                <div class="space-y-4" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="text-xl font-semibold text-gray-900">Personal Interests</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Primary Interest</label>
                            <select name="primary_interest" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                <option value="">Select Interest</option>
                                <option value="technology">Technology</option>
                                <option value="business">Business</option>
                                <option value="arts">Arts</option>
                                <option value="science">Science</option>
                                <option value="healthcare">Healthcare</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Secondary Interest</label>
                            <select name="secondary_interest" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                <option value="">Select Interest</option>
                                <option value="technology">Technology</option>
                                <option value="business">Business</option>
                                <option value="arts">Arts</option>
                                <option value="science">Science</option>
                                <option value="healthcare">Healthcare</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Skills and Aptitudes -->
                <div class="space-y-4" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="text-xl font-semibold text-gray-900">Skills and Aptitudes</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Technical Skills (Rate 1-5)</label>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600">Programming</label>
                                    <input type="range" min="1" max="5" name="programming_skill" class="w-full">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600">Mathematics</label>
                                    <input type="range" min="1" max="5" name="math_skill" class="w-full">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Family Background -->
                <div class="space-y-4" data-aos="fade-up" data-aos-delay="400">
                    <h2 class="text-xl font-semibold text-gray-900">Family Background</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Parent's Occupation</label>
                            <input type="text" name="parent_occupation" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Family Income Range</label>
                            <select name="family_income" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                <option value="">Select Range</option>
                                <option value="low">Low</option>
                                <option value="middle">Middle</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Personality Traits -->
                <div class="space-y-4" data-aos="fade-up" data-aos-delay="500">
                    <h2 class="text-xl font-semibold text-gray-900">Personality Traits</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Personality Type</label>
                            <select name="personality_type" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                <option value="">Select Type</option>
                                <option value="introvert">Introvert</option>
                                <option value="extrovert">Extrovert</option>
                                <option value="ambivert">Ambivert</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Leadership Style</label>
                            <select name="leadership_style" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                <option value="">Select Style</option>
                                <option value="directive">Directive</option>
                                <option value="collaborative">Collaborative</option>
                                <option value="delegative">Delegative</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- IQ Test Results -->
                <div class="space-y-4" data-aos="fade-up" data-aos-delay="600">
                    <h2 class="text-xl font-semibold text-gray-900">IQ Test Results</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IQ Score</label>
                            <input type="number" name="iq_score" min="70" max="160" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Test Date</label>
                            <input type="date" name="iq_test_date" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-8" data-aos="fade-up" data-aos-delay="700">
                    <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-full font-semibold hover:from-red-700 hover:to-red-600 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                        Submit Profile
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Initialize AOS
        AOS.init();

        // Form progress tracking
        const form = document.getElementById('studentForm');
        const progressBar = document.querySelector('.progress-bar');
        const formSections = form.querySelectorAll('div[data-aos]');

        function updateProgress() {
            const inputs = form.querySelectorAll('input, select');
            const filledInputs = Array.from(inputs).filter(input => input.value !== '');
            const progress = (filledInputs.length / inputs.length) * 100;
            progressBar.style.width = `${progress}%`;
        }

        form.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', updateProgress);
            input.addEventListener('change', updateProgress);
        });

        // Form validation and submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            alert('Form submitted successfully!');
        });
    </script>
</body>
</html> 