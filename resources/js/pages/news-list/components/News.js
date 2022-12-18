"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const moment = require("moment");
const classnames_1 = require("classnames");
const News = ({ news, disabled = false }) => {
    const handleSelectNews = (id) => {
        const baseUrl = window.location.origin;
        window.location.href = `${baseUrl}/news/${id}`;
    };
    const newsStyle = {
        backgroundImage: `url(${news.image})`
    };
    return (React.createElement("div", { className: classnames_1.default('col-auto news-list-item-wrapper', {
            'news-list-item-disabled': disabled,
        }) },
        React.createElement("div", { className: "news-list-item", key: news.id, onClick: () => handleSelectNews(news.id) },
            React.createElement("div", { className: "card news-list-card" },
                React.createElement("div", { className: "news-item-background", style: newsStyle }),
                React.createElement("span", { className: "news-item-title" }, news.title),
                React.createElement("div", { className: "news-item-date" }, moment(news.created_at).format('DD.MM.YYYY'))))));
};
exports.default = News;
