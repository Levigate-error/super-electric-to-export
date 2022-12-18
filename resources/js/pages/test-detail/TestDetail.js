"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const Test_1 = require("./components/Test/Test");
const antd_1 = require("antd");
class TestDetail extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            isLoading: false,
            test: this.props.store.test,
        };
    }
    render() {
        const { isLoading, test } = this.state;
        return (React.createElement("div", { className: "container test-detail-wrapper" }, isLoading ? (React.createElement("div", { className: "test-list-page-preloader-wrapper" },
            React.createElement(antd_1.Icon, { type: "loading", className: "test-list-page-preloader" }))) : (React.createElement("div", { className: "row mt-4" },
            React.createElement("div", { className: "col-12" },
                React.createElement(Test_1.default, { data: test }))))));
    }
}
exports.TestDetail = TestDetail;
exports.default = PageLayout_1.default(TestDetail);
