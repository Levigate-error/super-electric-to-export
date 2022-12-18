import * as React from 'react';
import Slider from 'react-slick';
import { getOthers } from './api';
import Product from '../Product';
import { Icon } from 'antd';
import { ArrowNext, ArrowPrev } from '../Slider/SliderArrows';

interface IByWithThis {
    productId: number;
}

const settings = {
    dots: false,
    infinite: false,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 4,
    initialSlide: 0,
    nextArrow: <ArrowNext />,
    prevArrow: <ArrowPrev />,
    className: 'product-detail-others-slider',
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

const ByWithThis = ({ productId }: IByWithThis): React.ReactElement => {
    const [products, setProducts] = React.useState([]);
    const [isLoading, setIsLoading] = React.useState(false);

    React.useEffect(() => {
        setIsLoading(true);
        getOthers(productId)
            .then(response => {
                setProducts(response.data);
                setIsLoading(false);
            })
            .catch(err => {
                setIsLoading(false);
            });
    }, []);
    return (
        <React.Fragment>
            {isLoading ? (
                <div className="preloader-wrapper">
                    <Icon type="loading" />
                </div>
            ) : (
                <div className="other-products">
                    {products.length > 0 && (
                        <React.Fragment>
                            <h3 className="slider-header">С этим товаром покупают:</h3>

                            <Slider {...settings}>
                                {products.map(product => (
                                    <Product product={product} key={product.id} />
                                ))}
                            </Slider>
                        </React.Fragment>
                    )}
                </div>
            )}
        </React.Fragment>
    );
};

export default ByWithThis;
