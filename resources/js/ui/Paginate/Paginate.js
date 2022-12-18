"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const react_paginate_1 = require("react-paginate");
const classnames_1 = require("classnames");
const antd_1 = require("antd");
const Paginate = ({ initialPage, pageCount, marginPagesDisplayed = 2, pageRangeDisplayed = 2, onPageChange, disabled = false, }) => {
    return (React.createElement("div", { className: classnames_1.default('legweb-paginate-wrapper', { 'legweb-paginate-disabled': disabled }) },
        React.createElement(react_paginate_1.default, { pageCount: pageCount, initialPage: initialPage, marginPagesDisplayed: marginPagesDisplayed, pageRangeDisplayed: pageRangeDisplayed, onPageChange: onPageChange, previousLabel: React.createElement(antd_1.Icon, { type: "left" }), nextLabel: React.createElement(antd_1.Icon, { type: "right" }), breakClassName: "legweb-paginate-break", breakLinkClassName: "legweb-paginate-break-link", pageClassName: "legweb-paginate-page", pageLinkClassName: "legweb-paginate-page-link", activeClassName: "legweb-paginate-active", activeLinkClassName: "legweb-paginate-active-link", previousClassName: "legweb-paginate-prev", nextClassName: "legweb-paginate-next", previousLinkClassName: "legweb-paginate-prev-link", nextLinkClassName: "legweb-paginate-next-link", disabledClassName: "legweb-paginate-disabled" })));
};
exports.default = Paginate;
