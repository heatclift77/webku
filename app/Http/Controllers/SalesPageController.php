<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SalesPage;
use App\Services\PublishService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesPageController extends Controller
{
    public function __construct(private PublishService $publishService) {}

    public function exportHtml(SalesPage $salesPage): StreamedResponse|RedirectResponse
    {
        $this->authorizeSalesPageOwnership($salesPage);

        try {
            $html = $this->renderSalesPageHtml($salesPage);

            return response()->streamDownload(function () use ($html) {
                echo $html;
            }, "sales-page-{$salesPage->id}.html", [
                'Content-Type' => 'text/html',
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to export HTML: '.$e->getMessage());
        }
    }

    public function publish(SalesPage $salesPage): RedirectResponse
    {
        $this->authorizeSalesPageOwnership($salesPage);

        try {
            // Create site if not exists
            if (! $salesPage->site_id) {
                $siteName = $this->generateSiteName($salesPage->product);
                $siteData = $this->publishService->createSite($siteName);

                $salesPage->update([
                    'site_id' => $siteData['site_id'],
                    'site_url' => $siteData['site_url'],
                ]);
            }

            $html = $this->renderSalesPageHtml($salesPage);
            $deployUrl = $this->publishService->publishHtml($html, $salesPage->site_id);

            $salesPage->update([
                'published_url' => $deployUrl,
            ]);

            return redirect()
                ->route('products.show', $salesPage->product)
                ->with('success', 'Sales page published successfully.');
        } catch (Exception $e) {
            return redirect()
                ->route('products.show', $salesPage->product)
                ->with('error', 'Failed to publish sales page: '.$e->getMessage());
        }
    }

    protected function authorizeSalesPageOwnership(SalesPage $salesPage): void
    {
        if ($salesPage->product->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized');
        }
    }

    protected function generateSiteName(Product $product): string
    {
        $slug = Str::slug($product->name);

        return $slug.'-'.$product->id;
    }

    protected function renderSalesPageHtml(SalesPage $salesPage): string
    {
        $templatePath = $this->resolveTemplatePath($salesPage);

        $content = View::make($templatePath, [
            'product' => $salesPage->product,
            'salesPage' => $salesPage,
        ])->render();

        return $this->wrapInHtmlDocument($content, $salesPage->product->name);
    }

    protected function resolveTemplatePath(SalesPage $salesPage): string
    {
        $template = $salesPage->template ?? 'modern';
        $templatePath = "templates.{$template}";

        if (! View::exists($templatePath)) {
            return 'templates.modern';
        }

        return $templatePath;
    }

    protected function wrapInHtmlDocument(string $content, string $title): string
    {
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'.htmlspecialchars($title).'</title>

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
    '.$content.'
</body>
</html>';
    }
}
