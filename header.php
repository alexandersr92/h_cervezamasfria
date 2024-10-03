<?php
$logo = get_field('logo', 'option');
$logo_secundario = get_field('logo_secundario', 'option');
$arrMenu = [
    'theme_location' => 'primary-menu',
    'container' => 'nav',
    'container_class' => 'nav',
    'menu_class' => 'nav__list',
    'menu_id' => 'nav__list',
    'fallback_cb' => false,
];
$arrMenu_mobile = [
    'theme_location' => 'primary-menu',
    'container' => 'nav',
    'container_class' => 'nav',
    'menu_class' => 'nav__list__mobile',
    'menu_id' => 'nav__list__mobile',
    'fallback_cb' => false,
];
?>


<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

    <link href="<?= get_template_directory_uri() ?>/assets/img/icon.png" rel="icon" type="image/png">
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '986093206186732');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=986093206186732&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DLNGFFZ5HS"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-DLNGFFZ5HS');
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NR2HS8CQ');
    </script>
    <!-- End Google Tag Manager -->


</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NR2HS8CQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php wp_body_open(); ?>

    <header class="bg-white fixed w-screen z-50">
        <div class="container relative">
            <div class="flex flex-row items-center justify-between pt-6">
                <a class="block " href="<?php echo home_url() ?>">
                    <img class="h-16" src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" />
                </a>
                <div class="h-7 ">

                    <img class="block h-[30px]" src="<?php echo $logo_secundario['url'] ?>" alt="<?php echo $logo_secundario['alt'] ?>" />
                </div>

                <div>
                    <div class="hidden md:block">

                        <?php echo wp_nav_menu($arrMenu) ?>
                    </div>
                    <div class="block md:hidden">
                        <button id="toggleMenu" type="button" aria-label="Menu" aria-controls="nav__list" aria-expanded="false">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary-400 menubtn" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 6l16 0" />
                                <path d="M4 12l16 0" />
                                <path d="M4 18l16 0" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x hidden closebtn" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>

                        </button>
                        <?php echo wp_nav_menu($arrMenu_mobile) ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="h-24  top-[53px] -z-50 absolute w-screen bgHeaderDeco">
    </header>