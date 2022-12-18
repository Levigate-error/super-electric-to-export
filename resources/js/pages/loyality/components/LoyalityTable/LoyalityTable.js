"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const api_1 = require("../../api");
const LoyalityTable = ({ loyaltyId }) => {
    const [allRowsIsVisible, setRowsVisibility] = React.useState(false);
    const [tableData, setTableData] = React.useState([]);
    const [isLoading, setIsLoading] = React.useState(false);
    React.useEffect(() => {
        setIsLoading(true);
        api_1.getLoyaltyProposals(loyaltyId).then(response => {
            setIsLoading(false);
            setTableData(response.data);
        });
    }, []);
    const columns = [
        {
            title: '№ п/п',
            dataIndex: 'id',
            key: 'id',
            width: 80,
            render: (id, record, index) => index + 1,
        },
        {
            title: 'Уникальный номер',
            dataIndex: 'code_text',
            key: 'code_text',
        },
        {
            title: 'Дата заявки',
            dataIndex: 'created_at',
            key: 'created_at',
            width: 120,
        },
        {
            title: 'Кол-во баллов',
            dataIndex: 'points',
            key: 'points',
        },
        {
            title: 'Статус',
            key: 'status_on_human',
            dataIndex: 'status_on_human',
            render: (data, row) => {
                return row.status === 'canceled' ? (React.createElement("span", { className: "loyalty-table-status-wrapper" },
                    data,
                    React.createElement(antd_1.Tooltip, { className: "loyalty-table-status-tooltip", title: React.createElement("span", null,
                            "\u0423\u043A\u0430\u0437\u0430\u043D\u043D\u044B\u0439 \u043A\u043E\u0434 \u0432 \u0437\u0430\u044F\u0432\u043A\u0435 \u043D\u0435 \u043D\u0430\u0439\u0434\u0435\u043D. \u041F\u043E\u0432\u0442\u043E\u0440\u0438\u0442\u0435 \u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u044E \u043A\u043E\u0434\u0430 \u0438\u043B\u0438",
                            ' ',
                            React.createElement("a", { href: "#", className: "legrand-text-btn" }, "\u043E\u0431\u0440\u0430\u0442\u0438\u0442\u0435\u0441\u044C \u0432 Legrand")) },
                        React.createElement(antd_1.Icon, { type: "question-circle", className: "loyalty-table-status-icon" })))) : (data);
            },
        },
    ];
    const handleToggleRowsVisibility = () => setRowsVisibility(!allRowsIsVisible);
    const rowsData = allRowsIsVisible ? tableData : tableData.slice(0, 3);
    return (React.createElement("div", { className: "loyality-table-wrapper" },
        React.createElement(antd_1.Table, { dataSource: rowsData, columns: columns, pagination: false, loading: isLoading, rowKey: "id", scroll: { x: 'max-content' } }),
        tableData.length > 3 && (React.createElement("button", { className: "legrand-text-btn loyality-table-show-more", onClick: handleToggleRowsVisibility }, allRowsIsVisible ? 'Свернуть таблицу' : 'Показать еще'))));
};
exports.default = LoyalityTable;
