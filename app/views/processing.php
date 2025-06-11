<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing...</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3b82f6;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .progress-bar {
            transition: width 0.5s ease-in-out;
        }
        .step {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease-in-out;
        }
        .step.active {
            opacity: 1;
            transform: translateY(0);
        }
        .step.completed {
            color: #10B981;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="text-center max-w-2xl mx-auto px-4">
        <div class="spinner mx-auto mb-8"></div>
        <h1 class="text-3xl font-bold text-white mb-4">Processing your data...</h1>
        
        <!-- Progress Bar -->
        <div class="w-full bg-gray-700 rounded-full h-2.5 mb-8">
            <div class="progress-bar bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
        </div>

        <!-- Processing Steps -->
        <div class="space-y-4 text-left">
            <div class="step" data-step="1">
                <p class="text-gray-300">✓ Analyzing academic profile...</p>
            </div>
            <div class="step" data-step="2">
                <p class="text-gray-300">✓ Evaluating career interests...</p>
            </div>
            <div class="step" data-step="3">
                <p class="text-gray-300">✓ Matching with potential careers...</p>
            </div>
            <div class="step" data-step="4">
                <p class="text-gray-300">✓ Generating personalized recommendations...</p>
            </div>
            <div class="step" data-step="5">
                <p class="text-gray-300">✓ Finalizing results...</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');
            const progressBar = document.querySelector('.progress-bar');
            let currentStep = 0;
            const totalSteps = steps.length;
            
            function updateProgress() {
                const progress = (currentStep / totalSteps) * 100;
                progressBar.style.width = `${progress}%`;
            }

            function processStep() {
                if (currentStep < totalSteps) {
                    steps[currentStep].classList.add('active');
                    setTimeout(() => {
                        steps[currentStep].classList.add('completed');
                        currentStep++;
                        updateProgress();
                        if (currentStep < totalSteps) {
                            processStep();
                        } else {
                            // All steps completed, check if recommendations are ready
                            checkRecommendations();
                        }
                    }, 800);
                }
            }

            function checkRecommendations() {
                // Check if recommendations are in session
                fetch('/check-recommendations')
                    .then(response => response.json())
                    .then(data => {
                        if (data.ready) {
                            window.location.href = '/recommendations';
                        } else {
                            // If not ready, wait and check again with exponential backoff
                            setTimeout(checkRecommendations, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error checking recommendations:', error);
                        // If there's an error, redirect to recommendations anyway
                        window.location.href = '/recommendations';
                    });
            }

            // Start processing immediately
            processStep();
        });
    </script>
</body>
</html> 