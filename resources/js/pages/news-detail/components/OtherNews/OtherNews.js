"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const News_1 = require("./News");
const OtherNews = ({ otherNews, currentId }) => {
    const prepareNews = () => {
        let arr = [];
        let counter = 0;
        for (let i = 0; otherNews.length > i; i++) {
            if (otherNews[i] && otherNews[i].id !== currentId && counter < 3) {
                counter++;
                arr = [...arr, React.createElement(News_1.default, { news: otherNews[i], key: otherNews[i].id })];
            }
        }
        return arr;
    };
    return React.createElement("div", { className: "row" }, prepareNews());
};
exports.default = OtherNews;
