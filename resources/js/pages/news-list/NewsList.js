"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const News_1 = require("./components/News");
const Paginate_1 = require("../../ui/Paginate");
const api_1 = require("./api");
class NewsList extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            currentPage: this.props.store.news.currentPage,
            total: this.props.store.news.total,
            lastPage: this.props.store.news.lastPage,
            isLoading: false,
            news: this.props.store.news.news,
        };
        this.handleChangePage = ({ selected }) => {
            const { currentPage } = this.state;
            const targetPage = selected + 1;
            if (currentPage !== targetPage) {
                this.handleGetNews(targetPage);
            }
        };
        this.handleGetNews = (page) => {
            this.setState({ isLoading: true });
            api_1.getNews({ page })
                .then(response => {
                const { data: { total, currentPage, news, lastPage }, } = response;
                this.setState({ isLoading: false, total, currentPage, news, lastPage });
            })
                .catch(err => { });
        };
    }
    render() {
        const { news, lastPage, currentPage, isLoading } = this.state;
        return (React.createElement("div", { className: "container news-list-wrapper" },
            React.createElement("div", { className: "row mt-4" },
                React.createElement("div", { className: "col-12" },
                    React.createElement("h3", null, "\u041D\u043E\u0432\u043E\u0441\u0442\u0438"))),
            React.createElement("div", { className: "row mt-3" }, news.map((item) => (React.createElement(News_1.default, { news: item, disabled: isLoading })))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-12 news-list-paginate " },
                    React.createElement(Paginate_1.default, { initialPage: currentPage - 1, pageCount: lastPage, pageRangeDisplayed: 2, onPageChange: this.handleChangePage, marginPagesDisplayed: 2, disabled: isLoading })))));
    }
}
exports.NewsList = NewsList;
exports.default = PageLayout_1.default(NewsList);
