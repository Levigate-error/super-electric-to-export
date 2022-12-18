import * as React from 'react';
import { Table, Tooltip, Icon } from 'antd';
import { getLoyaltyProposals } from '../../api';

interface ILoyalityTable {
    loyaltyId: number | boolean;
}

const LoyalityTable = ({ loyaltyId }: ILoyalityTable) => {
    const [allRowsIsVisible, setRowsVisibility] = React.useState(false);
    const [tableData, setTableData] = React.useState([]);
    const [isLoading, setIsLoading] = React.useState(false);

    React.useEffect(() => {
        setIsLoading(true);
        getLoyaltyProposals(loyaltyId).then(response => {
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
                return row.status === 'canceled' ? (
                    <span className="loyalty-table-status-wrapper">
                        {data}
                        <Tooltip
                            className="loyalty-table-status-tooltip"
                            title={
                                <span>
                                    Указанный код в заявке не найден. Повторите регистрацию кода или{' '}
                                    <a href="#" className="legrand-text-btn">
                                        обратитесь в Legrand
                                    </a>
                                </span>
                            }
                        >
                            <Icon type="question-circle" className="loyalty-table-status-icon" />
                        </Tooltip>
                    </span>
                ) : (
                    data
                );
            },
        },
    ];

    const handleToggleRowsVisibility = () => setRowsVisibility(!allRowsIsVisible);

    const rowsData = allRowsIsVisible ? tableData : tableData.slice(0, 3);

    return (
        <div className="loyality-table-wrapper">
            <Table
                dataSource={rowsData}
                columns={columns}
                pagination={false}
                loading={isLoading}
                rowKey="id"
                scroll={{ x: 'max-content' }}
            />
            {tableData.length > 3 && (
                <button className="legrand-text-btn loyality-table-show-more" onClick={handleToggleRowsVisibility}>
                    {allRowsIsVisible ? 'Свернуть таблицу' : 'Показать еще'}
                </button>
            )}
        </div>
    );
};

export default LoyalityTable;
