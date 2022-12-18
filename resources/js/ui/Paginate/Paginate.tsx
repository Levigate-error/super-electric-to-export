import * as React from 'react';
import ReactPaginate from 'react-paginate';
import classnames from 'classnames';
import { Icon } from 'antd';

interface IPaginate {
    pageCount: number;
    initialPage: number;
    pageRangeDisplayed?: number;
    marginPagesDisplayed?: number;
    disabled?: boolean;
    onPageChange: (val: any) => void;
}

const Paginate = ({
    initialPage,
    pageCount,
    marginPagesDisplayed = 2,
    pageRangeDisplayed = 2,
    onPageChange,
    disabled = false,
}: IPaginate): React.ReactElement => {
    return (
        <div className={classnames('legweb-paginate-wrapper', { 'legweb-paginate-disabled': disabled })}>
            <ReactPaginate
                pageCount={pageCount}
                initialPage={initialPage}
                marginPagesDisplayed={marginPagesDisplayed}
                pageRangeDisplayed={pageRangeDisplayed}
                onPageChange={onPageChange}
                previousLabel={<Icon type="left" />}
                nextLabel={<Icon type="right" />}
                breakClassName="legweb-paginate-break"
                breakLinkClassName="legweb-paginate-break-link"
                pageClassName="legweb-paginate-page"
                pageLinkClassName="legweb-paginate-page-link"
                activeClassName="legweb-paginate-active"
                activeLinkClassName="legweb-paginate-active-link"
                previousClassName="legweb-paginate-prev"
                nextClassName="legweb-paginate-next"
                previousLinkClassName="legweb-paginate-prev-link"
                nextLinkClassName="legweb-paginate-next-link"
                disabledClassName="legweb-paginate-disabled"
            />
        </div>
    );
};

export default Paginate;
