<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Protect the page
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

// Get recommendations from session
$recommendations = $_SESSION['recommendations'] ?? null;
if (!$recommendations) {
    header('Location: /dashboard');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Career Recommendations - AMA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        .recommendation-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .recommendation-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.3);
        }
        .gradient-text {
            background: linear-gradient(45deg, #3B82F6, #60A5FA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modern-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #60A5FA;
            margin-bottom: 1rem;
        }
        .section-content {
            color: #E5E7EB;
            line-height: 1.7;
        }
        .highlight-box {
            background: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #3B82F6;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen text-white">
    <?php require_once __DIR__ . '/layouts/header.php'; ?>

    <main class="max-w-7xl mx-auto py-10 px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="text-5xl font-bold mb-4 gradient-text">Your Career Journey</h1>
            <p class="text-gray-300 text-lg">Personalized recommendations tailored for your success</p>
        </div>

        <?php if ($recommendations['status'] === 'error'): ?>
            <div class="modern-card p-8 mb-8" data-aos="fade-up">
                <div class="flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-center mb-4">AI Service Status</h2>
                <p class="text-center text-gray-300 mb-4"><?php echo htmlspecialchars($recommendations['message']); ?></p>
            </div>
        <?php endif; ?>

        <div class="space-y-6" data-aos="fade-up">
            <?php
            // Split the response into sections and clean up formatting
            $sections = explode("\n\n", $recommendations['raw_response']);
            foreach ($sections as $index => $section):
                if (trim($section) === '') continue;
                
                // Clean up the text by removing asterisks and extra spaces
                $section = preg_replace('/\*+/', '', $section);
                $section = trim($section);
                
                // Check if this is a title section
                $isTitle = strpos($section, ':') !== false;
                $title = '';
                $content = $section;
                
                if ($isTitle) {
                    list($title, $content) = explode(':', $section, 2);
                    $content = trim($content);
                }
            ?>
                <div class="recommendation-card modern-card p-8 fade-in" 
                     style="animation-delay: <?php echo $index * 0.2; ?>s">
                    <?php if ($isTitle): ?>
                        <h3 class="section-title"><?php echo htmlspecialchars($title); ?></h3>
                    <?php endif; ?>
                    <div class="section-content">
                        <?php 
                        // Format the content with proper spacing and line breaks
                        $formattedContent = nl2br(htmlspecialchars($content));
                        // Add highlight boxes for important points
                        $formattedContent = preg_replace(
                            '/^([^<].*?)(?=\n|$)/m',
                            '<div class="highlight-box">$1</div>',
                            $formattedContent
                        );
                        echo $formattedContent;
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-12 text-center space-y-4" data-aos="fade-up">
            <p class="text-gray-400 text-sm">
                Generated on: <?php echo $recommendations['timestamp']; ?>
            </p>
            <?php if ($recommendations['status'] === 'error'): ?>
                <p class="text-red-400 text-sm">
                    Note: The AI service is currently experiencing issues. Please try again later.
                </p>
            <?php endif; ?>
            
            <div class="mt-8">
                <a href="/dashboard" 
                   class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-full font-semibold hover:from-blue-700 hover:to-blue-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </main>

    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>