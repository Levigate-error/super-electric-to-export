"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const react_image_gallery_1 = require("react-image-gallery");
const Icons_1 = require("../../../../ui/Icons/Icons");
function Slider({ imagesData }) {
    const prepareImagesData = () => {
        return imagesData.map(item => ({
            original: item.file_link,
            originalAlt: '',
        }));
    };
    const overrideImage = e => {
        e.target.src = '/images/default_product.jpg';
    };
    return imagesData.length > 0 ? (React.createElement(react_image_gallery_1.default, { items: prepareImagesData(), showBullets: true, showThumbnails: false, showFullscreenButton: false, showPlayButton: false, onImageError: overrideImage, defaultImage: "/images/default_product.jpg" })) : (React.createElement("div", { className: "product-detail-page-no-img" }, Icons_1.electroWhiteBackground));
}
exports.default = Slider;
