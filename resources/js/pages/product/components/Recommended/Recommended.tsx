import * as React from 'react';
import Slider from 'react-slick';
import { getRecommended } from './api';
import Product from '../Product';
import { Icon } from 'antd';
import { ArrowNext, ArrowPrev } from '../Slider/SliderArrows';

interface IRecommended {}

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

const Recommended = ({}: IRecommended): React.ReactElement => {
    const [recommended, setRecommended] = React.useState([]);
    const [isLoading, setIsLoading] = React.useState(false);

    React.useEffect(() => {
        setIsLoading(true);
        getRecommended()
            .then(response => {
                setRecommended(response.data);
                setIsLoading(false);
            })
            .catch(err => {
                setIsLoading(false);
            });
    }, []);
    return isLoading ? (
        <div className="preloader-wrapper">
            <Icon type="loading" />
        </div>
    ) : (
        <div className="other-products">
            {recommended.length > 0 && (
                <React.Fragment>
                    <h3 className="slider-header">Рекомендованное:</h3>

                    <Slider {...settings}>
                        {recommended.map(product => (
                            <Product product={product} key={product.id} />
                        ))}
                    </Slider>
                </React.Fragment>
            )}
        </div>
    );
};

export default Recommended;
