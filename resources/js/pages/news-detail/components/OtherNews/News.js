"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const moment = require("moment");
const News = ({ news }) => {
    const handleSelectNews = (id) => {
        const baseUrl = window.location.origin;
        window.location.href = `${baseUrl}/news/${id}`;
    };
    return (React.createElement("div", { className: "col-auto other-news-list-item-wrapper" },
        React.createElement("div", { className: "other-news-list-item", key: news.id, onClick: () => handleSelectNews(news.id) },
            React.createElement("div", { className: "card other-news-list-card" },
                React.createElement("span", { className: "other-news-item-title" }, news.title),
                React.createElement("div", { className: "other-news-item-date" }, moment(news.created_at).format('DD.MM.YYYY'))))));
};
exports.default = News;
