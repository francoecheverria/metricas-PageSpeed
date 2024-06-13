@include('components.header')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('/css/about/index.css') }}" rel="stylesheet">

    <title>About Metrics</title>
</head>

<body>
    <div class="container">
        <h1>About Metrics</h1>

        <div class="container">

            <h3>PageSpeed Insights</h3>
            <p class="description">PageSpeed Insights (PSI) reports on the user experience of a page on both mobile and desktop devices,
                and provides suggestions on how that page may be improved. PSI provides both lab and field data about a page. Lab data is useful for debugging issues, as it is
                collected in a controlled environment. However, it may not capture real-world bottlenecks. Field data is
                useful for capturing true, real-world user experience - but has a more limited set of metrics. See How
                To Think About Speed Tools for more information on the two types of data. </p>
            
            <h3>Real-user experience data</h3>
            <p class="description">Real-user experience data in PSI is powered by the Chrome User Experience Report (CrUX) dataset. PSI
                reports real users' First Contentful Paint (FCP), Interaction to Next Paint (INP), Largest Contentful
                Paint (LCP), and Cumulative Layout Shift (CLS) experiences over the previous 28-day collection period.
                PSI also reports experiences for the experimental metric Time to First Byte (TTFB), as well as the
                deprecated metric First Input Delay (FID).

                In order to show user experience data for a given page, there must be sufficient data for it to be
                included in the CrUX dataset. A page might not have sufficient data if it has been recently published or
                has too few samples from real users. When this happens, PSI will fall back to origin-level granularity,
                which encompasses all user experiences on all pages of the website. Sometimes the origin may also have
                insufficient data, in which case PSI will be unable to show any real-user experience data. </p>

        </div>

        <h3>Assessing quality of experiences</h3>
        <p class="description">PSI classifies the quality of user experiences into three buckets: Good, Needs Improvement, or Poor. PSI
            sets the following thresholds in alignment with the Web Vitals initiative: </p>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Métrica</th>
                        <th>Good</th>
                        <th>Needs Improvement</th>
                        <th>Poor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>FCP</td>
                        <td>[0, 1,800 ms]</td>
                        <td>(1,800 ms, 3,000 ms]</td>
                        <td>más de 3,000 ms</td>
                    </tr>
                    <tr>
                        <td>FID</td>
                        <td>[0, 100ms]</td>
                        <td>(100ms, 300ms]</td>
                        <td>más de 300 ms</td>
                    </tr>
                    <tr>
                        <td>LCP</td>
                        <td>[0, 2,500 ms]</td>
                        <td>(2,500 ms, 4,000 ms]</td>
                        <td>más de 4000 ms</td>
                    </tr>
                    <tr>
                        <td>CLS</td>
                        <td>[0, 0.1]</td>
                        <td>(0.1, 0.25)</td>
                        <td>más de 0.25</td>
                    </tr>
                    <tr>
                        <td>INP</td>
                        <td>[0, 200ms]</td>
                        <td>(200ms, 500ms]</td>
                        <td>más de 500 ms</td>
                    </tr>
                    <tr>
                        <td>TTFB (experimental)</td>
                        <td>[0, 800ms]</td>
                        <td>(800 ms, 1,800 ms]</td>
                        <td>más de 1,800 ms</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
