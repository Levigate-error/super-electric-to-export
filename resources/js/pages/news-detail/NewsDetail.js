"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
/* eslint-disable @typescript-eslint/camelcase */
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const moment = require("moment");
const OtherNews_1 = require("./components/OtherNews/OtherNews");
const api_1 = require("./api");
const antd_1 = require("antd");
class NewsDetail extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            otherNews: [],
            isLoading: false,
        };
        this.handleGetNews = () => {
            this.setState({ isLoading: true });
            api_1.getNews({})
                .then(response => {
                const { data: { news }, } = response;
                this.setState({ isLoading: false, otherNews: news });
            })
                .catch(err => { });
        };
    }
    componentDidMount() {
        this.handleGetNews();
    }
    render() {
        const { store: { news: { id, title, description, image, created_at }, }, } = this.props;
        const { otherNews, isLoading } = this.state;
        return (React.createElement("div", { className: "container news-detail-wrapper" },
            React.createElement("div", { className: "row mt-4" },
                React.createElement("div", { className: "col-12 col-md-8" },
                    React.createElement("h1", { className: "news-detail-title" }, title))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-12  col-md-8 news-detail-date" }, moment(created_at).format('DD.MM.YYYY'))),
            !!image && (React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-12  col-md-8" },
                    React.createElement("img", { src: image, className: "news-detail-image", alt: title })))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-12  col-md-8 news-detail-content", dangerouslySetInnerHTML: { __html: description } })),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-12  news-detail-back-to-news-wrapper" },
                    React.createElement("a", { href: "/news", className: "legrand-text-btn" }, "\u2190 \u0412\u0435\u0440\u043D\u0443\u0442\u044C\u0441\u044F \u043A \u0441\u043F\u0438\u0441\u043A\u0443 \u043D\u043E\u0432\u043E\u0441\u0442\u0435\u0439"))),
            !isLoading && !!otherNews.length && (React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-12" },
                    React.createElement("h3", { className: "other-news-title" }, "\u0414\u0440\u0443\u0433\u0438\u0435 \u043D\u043E\u0432\u043E\u0441\u0442\u0438")))),
            isLoading ? (React.createElement(antd_1.Icon, { type: "loading", className: "other-news-preloader" })) : (React.createElement(OtherNews_1.default, { otherNews: otherNews, currentId: id }))));
    }
}
exports.NewsDetail = NewsDetail;
exports.default = PageLayout_1.default(NewsDetail);
