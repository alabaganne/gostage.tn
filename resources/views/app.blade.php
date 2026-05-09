<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @php
            $baseTitle = 'Internly';
            $title = 'Internly - Find internships and manage student applications';
            $description = 'Internly is a public internship discovery platform where students find internships, apply online, and companies manage student applications from one clean workspace.';
            $type = 'website';
            $canonical = url()->current();
            $keywords = 'internships, student internships, internship platform, internship applications, hiring students, companies, career opportunities';
            $structuredData = [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => 'Internly',
                'url' => config('app.url'),
                'description' => $description,
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => config('app.url') . '/internships?search={search_term_string}',
                    'query-input' => 'required name=search_term_string',
                ],
            ];

            if (request()->routeIs('home')) {
                $title = 'Internly - Public internship board for students and companies';
                $description = 'Discover internships on Internly. Students can browse public internship opportunities, apply online, and connect with companies looking for emerging talent.';
            } elseif (request()->routeIs('internships.index')) {
                $title = 'Browse internships - Internly';
                $description = 'Browse public internship opportunities by field, city, and company on Internly. Find student internships and apply with a free account.';
            } elseif (request()->routeIs('internships.show') && request()->route('internship')) {
                $internship = request()->route('internship');
                $companyName = optional(optional($internship->company)->user)->name;
                $cityName = optional($internship->city)->name;
                $fieldName = optional($internship->field)->name;
                $title = $internship->title . ' internship' . ($companyName ? ' at ' . $companyName : '') . ' - Internly';
                $description = \Illuminate\Support\Str::limit(strip_tags($internship->description), 155);
                $type = 'article';
                $structuredData = [
                    '@context' => 'https://schema.org',
                    '@type' => 'JobPosting',
                    'title' => $internship->title,
                    'description' => strip_tags($internship->description),
                    'datePosted' => optional($internship->created_at)->toDateString(),
                    'validThrough' => optional($internship->closing_at)->toDateString(),
                    'employmentType' => 'INTERN',
                    'hiringOrganization' => [
                        '@type' => 'Organization',
                        'name' => $companyName ?: 'Internly company',
                    ],
                    'jobLocation' => [
                        '@type' => 'Place',
                        'address' => [
                            '@type' => 'PostalAddress',
                            'addressLocality' => $cityName ?: '',
                        ],
                    ],
                    'industry' => $fieldName ?: 'Internship',
                    'url' => $canonical,
                ];
            }
        @endphp

        <title>{{ $title }}</title>
        <meta name="description" content="{{ $description }}">
        <meta name="keywords" content="{{ $keywords }}">
        <link rel="canonical" href="{{ $canonical }}">
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

        <meta property="og:site_name" content="{{ $baseTitle }}">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:type" content="{{ $type }}">
        <meta property="og:url" content="{{ $canonical }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title }}">
        <meta name="twitter:description" content="{{ $description }}">

        <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

        <!-- Fonts -->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap"> -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
