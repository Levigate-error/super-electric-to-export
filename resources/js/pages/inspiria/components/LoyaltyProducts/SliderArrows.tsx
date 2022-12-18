import * as React from 'react';
import { Icon } from 'antd';

export function ArrowNext(props) {
    const { onClick, className } = props;
    return (
        <div className={className} onClick={onClick}>
            <Icon type="right" />
        </div>
    );
}

export function ArrowPrev(props) {
    const { onClick, className } = props;
    return (
        <div className={className} onClick={onClick}>
            <Icon type="left" />
        </div>
    );
}
