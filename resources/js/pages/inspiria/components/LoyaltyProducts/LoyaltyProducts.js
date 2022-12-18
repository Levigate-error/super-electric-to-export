"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const react_slick_1 = require("react-slick");
const api_1 = require("./api");
const Product_1 = require("../Product");
const antd_1 = require("antd");
const SliderArrows_1 = require("./SliderArrows");
const settings = {
    dots: false,
    infinite: false,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 4,
    initialSlide: 0,
    nextArrow: React.createElement(SliderArrows_1.ArrowNext, null),
    prevArrow: React.createElement(SliderArrows_1.ArrowPrev, null),
    className: 'loyalty-products-slider',
    responsive: [
        {
            breakpoint: 1199,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                initialSlide: 1,
            },
        },
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                initialSlide: 1,
            },
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                initialSlide: 1,
            },
        },
        {
            breakpoint: 575,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                initialSlide: 1,
            },
        },
    ],
};
const LoyaltyProducts = ({}) => {
    const [products, setProducts] = React.useState([]);
    const [isLoading, setIsLoading] = React.useState(false);
    React.useEffect(() => {
        setIsLoading(true);
        api_1.getLoyaltyProducts()
            .then(({ data }) => {
            data.products && setProducts(data.products);
        })
            .catch(err => { })
            .finally(() => setIsLoading(false));
    }, []);
    return isLoading ? (React.createElement("div", { className: "loyalty-products-preloader-wrapper" },
        React.createElement(antd_1.Icon, { type: "loading" }))) : (React.createElement("div", { className: "loyalty-products mt-3" }, products.length > 0 && (React.createElement(react_slick_1.default, Object.assign({}, settings), products.map(product => (React.createElement(Product_1.default, { product: product, key: product.id })))))));
};
exports.default = LoyaltyProducts;
