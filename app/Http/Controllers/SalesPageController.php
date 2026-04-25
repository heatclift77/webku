<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SalesPageController extends Controller
{
    public function exportHtml(SalesPage $salesPage)
    {
        // Check if user owns the sales page
        if ($salesPage->product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        try {
            // Get the template, default to 'modern' if not set or doesn't exist
            $template = $salesPage->template ?? 'modern';
            $templatePath = "templates.{$template}";

            // Check if template view exists, fallback to modern
            if (!View::exists($templatePath)) {
                $templatePath = 'templates.modern';
            }

            // Render the template with data
            $content = View::make($templatePath, [
                'product' => $salesPage->product,
                'salesPage' => $salesPage
            ])->render();

            // Create full HTML document
            $html = $this->wrapInHtmlDocument($content, $salesPage->product->name);

            // Return as downloadable file
            return response()->streamDownload(function () use ($html) {
                echo $html;
            }, "sales-page-{$salesPage->id}.html", [
                'Content-Type' => 'text/html',
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export HTML: ' . $e->getMessage());
        }
    }

    protected function wrapInHtmlDocument(string $content, string $title): string
    {
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($title) . '</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ["Inter", "system-ui", "sans-serif"],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: "Inter", system-ui, sans-serif;
            background-color: #ffffff;
            line-height: 1.6;
        }

        /* Ensure smooth scrolling and better typography */
        html {
            scroll-behavior: smooth;
        }

        /* Custom animations for startup template */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Ensure proper spacing and centering for standalone viewing */
        .export-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Fix any potential layout issues */
        .max-w-6xl {
            max-width: 72rem;
        }

        .max-w-4xl {
            max-width: 56rem;
        }

        /* Ensure buttons and links work properly */
        a {
            text-decoration: none;
        }

        /* Improve readability */
        p, li {
            line-height: 1.7;
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans antialiased export-container">
    ' . $content . '
</body>
</html>';
    }
}
