import * as React from 'react';
import Slider from 'react-slick';
import { getLoyaltyProducts } from './api';
import Product from '../Product';
import { Icon } from 'antd';
import { ArrowNext, ArrowPrev } from './SliderArrows';

interface ILoyaltyProducts {}

const settings = {
    dots: false,
    infinite: false,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 4,
    initialSlide: 0,
    nextArrow: <ArrowNext />,
    prevArrow: <ArrowPrev />,
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

const LoyaltyProducts = ({}: ILoyaltyProducts): React.ReactElement => {
    const [products, setProducts] = React.useState([]);
    const [isLoading, setIsLoading] = React.useState(false);

    React.useEffect(() => {
        setIsLoading(true);
        getLoyaltyProducts()
            .then(({ data }) => {
                data.products && setProducts(data.products);
            })
            .catch(err => {})
            .finally(() => setIsLoading(false));
    }, []);
    return isLoading ? (
        <div className="loyalty-products-preloader-wrapper">
            <Icon type="loading" />
        </div>
    ) : (
        <div className="loyalty-products mt-3">
            {products.length > 0 && (
                <Slider {...settings}>
                    {products.map(product => (
                        <Product product={product} key={product.id} />
                    ))}
                </Slider>
            )}
        </div>
    );
};

export default LoyaltyProducts;
