import * as React from 'react';
import ImageGallery from 'react-image-gallery';
import { ISlider } from './types';
import { electroWhiteBackground } from '../../../../ui/Icons/Icons';

export default function Slider({ imagesData }: ISlider) {
    const prepareImagesData = () => {
        return imagesData.map(item => ({
            original: item.file_link,
            originalAlt: '',
        }));
    };

    const overrideImage = e => {
        e.target.src = '/images/default_product.jpg';
    };

    return imagesData.length > 0 ? (
        <ImageGallery
            items={prepareImagesData()}
            showBullets
            showThumbnails={false}
            showFullscreenButton={false}
            showPlayButton={false}
            onImageError={overrideImage}
            defaultImage="/images/default_product.jpg"
        />
    ) : (
        <div className="product-detail-page-no-img">{electroWhiteBackground}</div>
    );
}
