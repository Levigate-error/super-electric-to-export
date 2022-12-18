import * as React from 'react';
import Spinner from '../../ui/Spinner';
import classnames from 'classnames';
import { Icon } from 'antd';

const withIconBorderStyle = {
    borderRight: 'none',
};

const spinnerStyle = {
    position: 'relative',
    height: '24px',
    width: '24px',
    transform: 'scale(0.5)',
    top: '-9px',
    left: '-9px',
};

interface IInput {
    value?: string | number;
    isLoading?: boolean;
    placeholder?: string;
    icon?: any;
    name?: string;
    onChange?: (event: any) => void;
    type?: string;
    id?: string | number;
    required?: boolean;
    iconAction?: () => void;
    disabled?: boolean;
    label?: string | false;
    isPassword?: boolean;
    error?: boolean | string;
    tabindex?: number;
    className?: string;
    autoComplete?: 'on' | 'off';
}

function Input({
    value,
    onChange = () => {},
    placeholder = '',
    id,
    icon,
    name = '',
    isLoading = false,
    type = 'text',
    required = false,
    iconAction,
    disabled,
    label = false,
    isPassword = false,
    error = false,
    tabindex = 0,
    className,
    autoComplete = 'on',
}: IInput) {
    const [stateValue, setStateValue] = React.useState(value);
    const [textSecurity, setTextSecurity] = React.useState(isPassword);

    React.useEffect(() => {
        setStateValue(value);
    }, [value]);

    const handleChange = e => {
        if (!disabled) {
            setStateValue(e.target.value);
            onChange(e);
        }
    };

    const handleChangeTextSecurity = () => setTextSecurity(!textSecurity);

    const handleIconClick = () => {
        if (isPassword) {
            handleChangeTextSecurity();
        } else {
            iconAction && iconAction();
        }
    };

    const checkError = () => {
        if (required) {
            if (typeof error === 'boolean' && stateValue === '') return 'Обязательное поле';
            if (typeof error === 'boolean' && stateValue !== '') return 'Введены некоректные данные';
        } else {
            if (typeof error === 'string') return error;
            if (typeof error === 'boolean') return 'Введены некоректные данные';
        }
    };

    const showIcon = icon || isPassword;

    return (
        <div
            className={classnames(
                'legrand-input-wrapper',
                {
                    'legrand-input-disabled': disabled,
                },
                { 'with-label': label },
                className,
            )}
        >
            <div className="legrand-input-labels">
                {label && <span className="label-wrapper">{label}</span>}

                {error && <span className="label-error">{checkError()}</span>}
            </div>
            <div className="legrand-input-controls-wrapper">
                <input
                    type={isPassword && textSecurity ? 'password' : type}
                    className={classnames('form-control shadow-none legrand-input', {
                        'legrand-input-password': textSecurity,
                    })}
                    placeholder={placeholder}
                    value={stateValue}
                    onChange={handleChange}
                    style={icon ? withIconBorderStyle : {}}
                    name={name}
                    data-id={id || ''}
                    autoComplete={autoComplete}
                    tabIndex={tabindex}
                    required
                />
                {showIcon && (
                    <div
                        className={classnames('input-group-append legrand-input-append', {
                            'legrand-input-append-icon-btn': !!iconAction || isPassword,
                        })}
                        onClick={handleIconClick}
                    >
                        <div className="input-group-text">
                            {isLoading ? (
                                <Spinner style={spinnerStyle} />
                            ) : isPassword ? (
                                textSecurity ? (
                                    <Icon type="eye" />
                                ) : (
                                    <Icon type="eye-invisible" />
                                )
                            ) : (
                                icon
                            )}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}

export default React.memo(Input);
