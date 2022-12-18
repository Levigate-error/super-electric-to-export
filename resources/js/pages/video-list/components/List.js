"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const VideoItem_1 = require("./VideoItem");
const List = ({ videos }) => {
    return (React.createElement(React.Fragment, null, videos.length
        ? videos.map(item => React.createElement(VideoItem_1.default, { item: item, key: item.id }))
        : 'По Вашему запросу видео не найдены'));
};
exports.default = List;
