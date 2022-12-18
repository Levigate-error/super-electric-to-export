"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Category_1 = require("./Category");
function Categories({ filtersData, selectFilter, checkedFilters }) {
    return (React.createElement(React.Fragment, null, filtersData.map((filter) => {
        const { name, id, values } = filter;
        return (React.createElement(Category_1.default, { key: id, categoryId: id, name: name, values: values, selectFilter: selectFilter, checkedFilters: checkedFilters }));
    })));
}
exports.default = React.memo(Categories);
