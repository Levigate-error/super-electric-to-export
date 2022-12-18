import * as React from 'react';
import classnames from 'classnames';
import { Icon } from 'antd';

interface IButton {
    disabled?: boolean;
    value: string | React.ReactNode;
    isLoading?: boolean;
    appearance?: 'accent' | 'second' | 'bordered';
    isActive?: boolean;
    onClick?: (e?: React.SyntheticEvent) => void;
    style?: any;
    className?: string;
    type?: 'submit' | 'reset' | 'button';
    small?: boolean;
    tabindex?: number;
}

function Button({
    disabled,
    value,
    onClick,
    appearance,
    isActive,
    type,
    style = {},
    className,
    isLoading = false,
    small = false,
    tabindex = 0,
}: IButton) {
    function checkType() {
        switch (appearance) {
            case 'accent':
                return 'btn-accent';
            case 'second':
                return 'btn-second';
            case 'bordered':
                return 'btn-bordered';
            default:
                return 'btn-accent';
        }
    }

    return (
        <button
            className={classnames(
                'legrand-btn',
                checkType(),
                {
                    active: isActive,
                },
                className,
                { 'legrand-btn-small': small },
                { 'legrand-btn-disabled': disabled },
            )}
            onClick={onClick}
            disabled={disabled || isLoading}
            style={style}
            type={type || 'button'}
            tabIndex={tabindex}
        >
            {value} {isLoading && <Icon type="loading" className="legrand-btn-loading-icon" />}
        </button>
    );
}

export default Button;
