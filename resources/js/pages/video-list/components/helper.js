"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.getPreviewImage = (video) => {
    const urlInfoArr = video.split('/');
    const background = `https://img.youtube.com/vi/${urlInfoArr[urlInfoArr.length - 1]}/hqdefault.jpg`;
    return `url(${background}) `;
};
