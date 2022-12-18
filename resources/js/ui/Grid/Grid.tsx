import * as React from 'react';
import { Table } from 'antd';
import { PaginationConfig } from 'antd/lib/pagination';

interface IGrid {
    data: any;
    columns: any;
    paging?: false | PaginationConfig;
    rowClick?: (record: any, rowIndex: number) => void;
    isLoading?: boolean;
}

function Grid({ data, columns, paging, rowClick, isLoading = false }: IGrid) {
    return (
        <Table
            className="legrand-grid"
            loading={isLoading}
            dataSource={data}
            columns={columns}
            pagination={paging}
            rowKey={(record: any) => record.id}
            onRow={(record, rowIndex) => ({
                onClick: () => rowClick(record, rowIndex),
            })}
        />
    );
}

export default Grid;
