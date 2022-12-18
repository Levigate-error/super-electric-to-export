const mix = require('laravel-mix');
console.log('mix.client')
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
        optimization: {
            minimize: true,
        },
    };
});

// home page
mix.react('./resources/js/pages/home/App.js', './public/js/pages/home')
    // catalog page
    .react('resources/js/pages/catalog/App.js', 'public/js/pages/catalog')
    // loyality page
    .react('resources/js/pages/loyality/App.js', 'public/js/pages/loyality')
    // inspiria page
    .react('resources/js/pages/inspiria/App.js', 'public/js/pages/inspiria')
    // promo page
    .react('resources/js/pages/promo/App.js', 'public/js/pages/promo')
    // profile page
    .react('resources/js/pages/profile/App.js', 'public/js/pages/profile')
    // faq page
    .react('resources/js/pages/faq/App.js', 'public/js/pages/faq')
    // news-detail page
    .react('resources/js/pages/news-detail/App.js', 'public/js/pages/news-detail')
    // news-list page
    .react('resources/js/pages/news-list/App.js', 'public/js/pages/news-list')
    // test-detail page
    .react('resources/js/pages/test-detail/App.js', 'public/js/pages/test-detail')
    // test-list page
    .react('resources/js/pages/test-list/App.js', 'public/js/pages/test-list')
    // video-list page
    .react('resources/js/pages/video-list/App.js', 'public/js/pages/video-list')
    // product page
    .react('resources/js/pages/product/App.js', 'public/js/pages/product')
    // project form
    .react('resources/js/pages/project-form/App.js', 'public/js/pages/project-form')
    // projects list page
    .react('resources/js/pages/projects-list/App.js', 'public/js/pages/projects-list')
    // project products page
    .react('resources/js/pages/project-products/App.js', 'public/js/pages/project-products')
    // project specification
    .react('resources/js/pages/project-spec/App.js', 'public/js/pages/project-spec')

    .sass('resources/sass/app.scss', 'public/css');
