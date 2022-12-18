"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const TestItem_1 = require("./components/TestItem");
const api_1 = require("./api");
const antd_1 = require("antd");
class VideoList extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            testsList: [],
            isLoading: true,
        };
    }
    componentDidMount() {
        api_1.getTestsList()
            .then(response => {
            this.setState({ testsList: response.data, isLoading: false });
        })
            .catch(err => {
            this.setState({ isLoading: false });
        });
    }
    render() {
        const { testsList, isLoading } = this.state;
        return (React.createElement("div", { className: "container test-list-wrapper" },
            React.createElement("div", { className: "row mt-4" },
                React.createElement("div", { className: "col-12" },
                    React.createElement("h3", null, "\u0422\u0435\u0441\u0442\u044B"))),
            !isLoading ? (React.createElement("div", { className: "row mt-3" }, testsList.map(test => (React.createElement(TestItem_1.default, { test: test, key: test.id }))))) : (React.createElement("div", { className: "test-list-page-preloader-wrapper" },
                React.createElement(antd_1.Icon, { type: "loading", className: "test-list-page-preloader" })))));
    }
}
exports.VideoList = VideoList;
exports.default = PageLayout_1.default(VideoList);
