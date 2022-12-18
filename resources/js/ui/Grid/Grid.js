"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
function Grid({ data, columns, paging, rowClick, isLoading = false }) {
    return (React.createElement(antd_1.Table, { className: "legrand-grid", loading: isLoading, dataSource: data, columns: columns, pagination: paging, rowKey: (record) => record.id, onRow: (record, rowIndex) => ({
            onClick: () => rowClick(record, rowIndex),
        }) }));
}
exports.default = Grid;
