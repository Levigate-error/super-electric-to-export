const mix = require('laravel-mix');
console.log('mix.server')
mix.webpackConfig(() => {
    return {
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    use: 'ts-loader',
                    exclude: /(node_modules|bower_components)/,
                },
            ],
        },
        resolve: {
            extensions: ['.tsx', '.ts', '.jsx', '.js'],
            modules: [path.resolve(__dirname, 'resources/js'), 'node_modules'],
        },
    };
});

// // home page
mix.react('resources/js/pages/home/home-server.js', 'public/js/pages/home')
    // catalog page
    .react('resources/js/pages/catalog/catalog-server.js', 'public/js/pages/catalog')
    // loyality page
    .react('resources/js/pages/loyality/loyality-server.js', 'public/js/pages/loyality')
    // inspiria page
    .react('resources/js/pages/inspiria/inspiria-server.js', 'public/js/pages/inspiria')
    // promo page
    .react('resources/js/pages/promo/promo-server.js', 'public/js/pages/promo')
    // profile page
    .react('resources/js/pages/profile/profile-server.js', 'public/js/pages/profile')
    // faq page
    .react('resources/js/pages/faq/faq-server.js', 'public/js/pages/faq')
    // news-detail page
    .react('resources/js/pages/news-detail/news-detail-server.js', 'public/js/pages/news-detail')
    // news-list page
    .react('resources/js/pages/news-list/news-list-server.js', 'public/js/pages/news-list')
    // test-detail page
    .react('resources/js/pages/test-detail/test-detail-server.js', 'public/js/pages/test-detail')
    // test-list page
    .react('resources/js/pages/test-list/test-list-server.js', 'public/js/pages/test-list')
    // video-list page
    .react('resources/js/pages/video-list/video-list-server.js', 'public/js/pages/video-list')
    // product page
    .react('resources/js/pages/product/product-server.js', 'public/js/pages/product')
    // project form
    .react('resources/js/pages/project-form/project-form-server.js', 'public/js/pages/project-form')
    // projects list page
    .react('resources/js/pages/projects-list/list-server.js', 'public/js/pages/projects-list')
    // project products page
    .react('resources/js/pages/project-products/project-products-server.js', 'public/js/pages/project-products')
    // project specification
    .react('resources/js/pages/project-spec/project-spec-server.js', 'public/js/pages/project-spec')

    .sass('resources/sass/app.scss', 'public/css');
