const mix = require('laravel-mix');
console.log('just mix')
if (process.env.TARGET === 'client') {
    require(`${__dirname}/webpack.mix.${process.env.TARGET}.js`);
} else if (process.env.TARGET === 'server') {
    require(`${__dirname}/webpack.mix.${process.env.TARGET}.js`);
} else {
    mix.webpackConfig(() => {
        return {
            module: {
                rules: [
                    {
                        test: /\.(js|jsx)$/,
                        exclude: /node_modules/,
                        use: ["babel-loader"],
                    },
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
    mix.react('resources/js/pages/home/App.js', 'public/js/pages/home')
        .react('resources/js/pages/home/home-server.js', 'public/js/pages/home')
        // catalog page
        .react('resources/js/pages/catalog/App.js', 'public/js/pages/catalog')
        .react('resources/js/pages/catalog/catalog-server.js', 'public/js/pages/catalog')
        // loyality page
        .react('resources/js/pages/loyality/App.js', 'public/js/pages/loyality')
        .react('resources/js/pages/loyality/loyality-server.js', 'public/js/pages/loyality')
        // inspiria page
        .react('resources/js/pages/inspiria/App.js', 'public/js/pages/inspiria')
        .react('resources/js/pages/inspiria/inspiria-server.js', 'public/js/pages/inspiria')
        // promo page
        .react('resources/js/pages/promo/App.js', 'public/js/pages/promo')
        .react('resources/js/pages/promo/promo-server.js', 'public/js/pages/promo')
        // profile page
        .react('resources/js/pages/profile/App.js', 'public/js/pages/profile')
        .react('resources/js/pages/profile/profile-server.js', 'public/js/pages/profile')
        // faq page
        .react('resources/js/pages/faq/App.js', 'public/js/pages/faq')
        .react('resources/js/pages/faq/faq-server.js', 'public/js/pages/faq')
        // news-detail page
        .react('resources/js/pages/news-detail/App.js', 'public/js/pages/news-detail')
        .react('resources/js/pages/news-detail/news-detail-server.js', 'public/js/pages/news-detail')
        // news-list page
        .react('resources/js/pages/news-list/App.js', 'public/js/pages/news-list')
        .react('resources/js/pages/news-list/news-list-server.js', 'public/js/pages/news-list')
        // test-detail page
        .react('resources/js/pages/test-detail/App.js', 'public/js/pages/test-detail')
        .react('resources/js/pages/test-detail/test-detail-server.js', 'public/js/pages/test-detail')
        // test-list page
        .react('resources/js/pages/test-list/App.js', 'public/js/pages/test-list')
        .react('resources/js/pages/test-list/test-list-server.js', 'public/js/pages/test-list')
        // video-list page
        .react('resources/js/pages/video-list/App.js', 'public/js/pages/video-list')
        .react('resources/js/pages/video-list/video-list-server.js', 'public/js/pages/video-list')
        // product page
        .react('resources/js/pages/product/App.js', 'public/js/pages/product')
        .react('resources/js/pages/product/product-server.js', 'public/js/pages/product')
        // project form
        .react('resources/js/pages/project-form/App.js', 'public/js/pages/project-form')
        .react('resources/js/pages/project-form/project-form-server.js', 'public/js/pages/project-form')
        // projects list page
        .react('resources/js/pages/projects-list/App.js', 'public/js/pages/projects-list')
        .react('resources/js/pages/projects-list/list-server.js', 'public/js/pages/projects-list')
        // project products page
        .react('resources/js/pages/project-products/App.js', 'public/js/pages/project-products')
        .react('resources/js/pages/project-products/project-products-server.js', 'public/js/pages/project-products')
        // project specification
        .react('resources/js/pages/project-spec/App.js', 'public/js/pages/project-spec')
        .react('resources/js/pages/project-spec/project-spec-server.js', 'public/js/pages/project-spec')

        .sass('resources/sass/app.scss', 'public/css');
}
