"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const api_1 = require("./api");
const reducer_1 = require("./reducer");
const NewsDetail_1 = require("./NewsDetail");
const classnames_1 = require("classnames");
const News = ({}) => {
    const [{ currentNews, isLoading, news, error }, dispatch] = React.useReducer(reducer_1.reducer, reducer_1.initialState);
    const handleGetNews = (page) => {
        dispatch({ type: reducer_1.actionTypes.FETCH_NEWS });
        api_1.getNews({ page })
            .then(response => {
            const { data: { news }, } = response;
            dispatch({ type: reducer_1.actionTypes.FETCH_NEWS_SUCCESS, payload: news });
        })
            .catch(err => {
            dispatch({ type: reducer_1.actionTypes.FETCH_NEWS_FAILURE });
        });
    };
    React.useEffect(() => {
        handleGetNews(1);
    }, []);
    const nextAvailable = news.length - 1 > currentNews;
    const prevAvailable = currentNews > 0;
    const newsAvailable = news.length > 0;
    const handleNext = () => {
        if (nextAvailable) {
            dispatch({ type: reducer_1.actionTypes.SET_CURRENT_NEWS, payload: currentNews + 1 });
        }
    };
    const handlePrev = () => {
        if (prevAvailable) {
            dispatch({ type: reducer_1.actionTypes.SET_CURRENT_NEWS, payload: currentNews - 1 });
        }
    };
    return (React.createElement("div", { className: "card home-page-card mb-3" },
        !isLoading && !error && newsAvailable && (React.createElement("div", { className: "home-page-news-btns-wrapper" },
            React.createElement(antd_1.Icon, { type: "left", onClick: handlePrev, className: classnames_1.default('home-page-news-btn', {
                    'home-page-news-btn-disabled': !prevAvailable,
                }) }),
            React.createElement(antd_1.Icon, { type: "right", onClick: handleNext, className: classnames_1.default('home-page-news-btn', {
                    'home-page-news-btn-disabled': !nextAvailable,
                }) }))),
        React.createElement("div", { className: "news-wrapper" },
            React.createElement("div", { className: "home-page-card-background news-bg" }),
            React.createElement("span", { className: "home-page-card-news-title title" },
                React.createElement("a", { href: "/news", className: "home-page-card-news-title-link" }, "\u041D\u043E\u0432\u043E\u0441\u0442\u0438")),
            !isLoading && error && React.createElement("div", { className: "home-page-loading-news-error" }, "\u041E\u0448\u0438\u0431\u043A\u0430 \u0437\u0430\u0433\u0440\u0443\u0437\u043A\u0438 \u043D\u043E\u0432\u043E\u0441\u0442\u0435\u0439"),
            !isLoading && !newsAvailable && !error && (React.createElement("div", { className: "home-page-news-not-found" }, "\u041D\u043E\u0432\u043E\u0441\u0442\u0438 \u043E\u0442\u0441\u0443\u0442\u0441\u0442\u0432\u0443\u044E\u0442")),
            isLoading && !error ? (React.createElement(antd_1.Icon, { type: "loading", className: "home-page-news-loading" })) : (newsAvailable && React.createElement(NewsDetail_1.default, { news: news[currentNews] })))));
};
exports.default = News;
